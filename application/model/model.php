<?php

class Model
{
    /**
     * @param object $db A PDO database connection
     */
    function __construct($db)
    {
        try {
            $this->db = $db;
        } catch (PDOException $e) {
            exit('Database connection could not be established.');
        }
    }


    /**
     * Register user
     */

        public function checkEmailExists($email){
            try {

                $sql = "SELECT email FROM users WHERE email=:email";
                $stmt = $this->db->prepare($sql);
                $parameters = array(':email'=>$email);

                $stmt->execute($parameters);
                $row = $stmt->fetch();
                
    
                    if($stmt->rowCount() > 0){       
                        if($row->email==$email) {
                            return true;
                            } else {
                                return false;
                            }
                    } else {
                        return false;
                    }

                
                
    
            } catch(PDOException $e) {
                echo $e->getMessage();
            }
            
        }

        public function checkUsernameExists($username){
            try {

                $sql = "SELECT username FROM users WHERE username=:username";
                $stmt = $this->db->prepare($sql);
                $parameters = array(':username'=>$username);

                $stmt->execute($parameters);
                
                $row = $stmt->fetch();
                            
                if($row->username==$username) {
                return true;
                } else {
                    return false;
                }
    
            } catch(PDOException $e) {
                echo $e->getMessage();
            }
            
        }
    
        public function registerUser($username, $firstname, $lastname, $email, $password)
        {

                $password = sha1($password);

                $sql = "INSERT INTO users(username, firstname, lastname, email, password) 
                        VALUES(:username, :firstname, :lastname, :email, :password)";
                $stmt = $this->db->prepare($sql);
                $parameters = array(':username'=>$username,
                                    ':firstname'=>$firstname,
                                    ':lastname'=>$lastname,
                                    ':email'=>$email,
                                    ':password'=>$password);

                // echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters);  exit();
                

                $stmt->execute($parameters);

                $last_id = $this->db->lastInsertId();

                try {	    
                    if($stmt->rowCount() > 0){
                        $this->SetPref($last_id);

                        return $last_id;	
                    } else {
                        return false;
                    }

                } catch(PDOException $e) {
                    echo $e->getMessage();
                }


        }
    

    /**
     * Login user
     */

        public function doLogin($email,$password)
        {
            $password = sha1($password);

            $sql = "SELECT * FROM users WHERE email=:email AND password =:password";
            $stmt = $this->db->prepare($sql);
            $parameters = array(':email'=>$email, ':password'=>$password);

            $stmt->execute($parameters);
            $userDetails = $stmt->fetch();

            try {	    
                if($stmt->rowCount() == 1){       
                    return $userDetails;	
                } else {
                    return false;
                }

            } catch(PDOException $e) {
                echo $e->getMessage();
            }

        }
		


    /**
     * Update 
     */

        public function updateEmail($email, $user_id)
        {
            try{	
                
                $sql = "UPDATE users
                        SET email = :email
                        WHERE id = :id";
                $stmt = $this->db->prepare($sql);
                $parameters = array(':email'=>$email, ':id'=>$user_id);
                $stmt->execute($parameters);							  
                    
            } catch(PDOException $e) {
                echo $e->getMessage();
            }		
            $this->updateSession($user_id);
        }

        public function updateUsername($username, $user_id)
        {
            try{	
                
                $sql = "UPDATE users
                        SET username = :username
                        WHERE id = :id";
                $stmt = $this->db->prepare($sql);
                $parameters = array(':username'=>$username, ':id'=>$user_id);
                // echo Helper::debugPDO($sql, $parameters); die();
                $stmt->execute($parameters);							  
                    
            } catch(PDOException $e) {
                echo $e->getMessage();
            }		
            $this->updateSession($user_id);
        }

        public function updateDetails($firstname, $lastname, $user_id)
        {
            try{	
                $sql = "UPDATE users
                        SET firstname = :firstname,
                            lastname = :lastname
                        WHERE id = :id";
                $stmt = $this->db->prepare($sql);
                $parameters = array(':firstname'=>$firstname, ':lastname'=>$lastname, ':id'=>$user_id);
                // echo Helper::debugPDO($sql, $parameters); die();
                $stmt->execute($parameters);							  
                    
            } catch(PDOException $e) {
                echo $e->getMessage();
            }		
            $this->updateSession($user_id);
        }

        public function updatePassword($password, $user_id)
        {
            try{	
                $sql = "UPDATE users
                        SET password = :password
                        WHERE id = :id";
                $stmt = $this->db->prepare($sql);
                $parameters = array(':password'=>$password, ':id'=>$user_id);
                // echo Helper::debugPDO($sql, $parameters); die();
                $stmt->execute($parameters);							  
                    
            } catch(PDOException $e) {
                echo $e->getMessage();
            }		
            $this->updateSession($user_id);
        }

        



        public function updateSession($user_id)
        {

            $sql = "SELECT * FROM users WHERE id=:id";
            $stmt = $this->db->prepare($sql);
            $parameters = array(':id'=>$user_id);


            $stmt->execute($parameters);
            $userDetails = $stmt->fetch();

            try {	    
                if($stmt->rowCount() == 1){       
                    $_SESSION['user_session'] = $userDetails;	
                } else {
                    return false;
                }

            } catch(PDOException $e) {
                echo $e->getMessage();
            }
        }



        /**
     * Feed 
     */



        public function getFeedItems($lat, $lon, $minLat, $minLon, $maxLat, $maxLon, $rad, $R, $search)
        {


            $sql = "SELECT  posts.id, posts.user_id, posts.post_image, posts.content, posts.loves, posts.Lat, posts.Lon,
                            users.username, users.image, tags.name, 
                            acos(sin(:lat)*sin(radians(posts.Lat)) + cos(:lat)*cos(radians(posts.Lat))*cos(radians(posts.Lon)-:lon)) * :R AS D
                    FROM (
                        SELECT id, user_id, content, loves, Lat, Lon
                        FROM posts
                        WHERE Lat BETWEEN :minLat AND :maxLat
                        AND Lon BETWEEN :minLon AND :maxLon
                    ) AS FirstCut
                    JOIN users ON FirstCut.user_id = users.id
                    JOIN posts ON FirstCut.id = posts.id
                    LEFT JOIN tags___posts ON posts.id = tags___posts.post_id
                    LEFT JOIN tags ON tags.id = tags___posts.tag_id
                    WHERE acos(sin(:lat)*sin(radians(posts.Lat)) + cos(:lat)*cos(radians(posts.Lat))*cos(radians(posts.Lon)-:lon)) * :R2 < :rad
                    AND posts.content LIKE :search
                    OR tags.name LIKE :search
                    ORDER BY D, posts.id DESC
                    ";
            $stmt = $this->db->prepare($sql);
            $parameters = [
                ':lat'    => deg2rad($lat),
                ':lon'    => deg2rad($lon),
                ':minLat' => $minLat,
                ':minLon' => $minLon,
                ':maxLat' => $maxLat,
                ':maxLon' => $maxLon,
                ':rad'    => $rad,
                ':R'      => $R,
                ':R2'      => $R,
                ':search'      => '%'.$search.'%',
            ];

            // echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters);  exit();

            

            $stmt->execute($parameters);
            $feedItems = $stmt->fetchAll();

            try {	    
                if($stmt->rowCount() > 0){   
                    return $feedItems;	
                } else {
                    return false;
                }

            } catch(PDOException $e) {
                echo $e->getMessage();
            }

        }


        public function getFeedReplies($id)
        {
            $sql = "SELECT post_replies.id, post_replies.post_id, post_replies.user_id, post_replies.content, post_replies.loves, users.username, users.image FROM post_replies 
                    JOIN users on users.id = post_replies.user_id
                    WHERE post_id = :id";
            $stmt = $this->db->prepare($sql);
            $parameters = [ ':id' => $id ];
            // echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters);  exit();
            $stmt->execute($parameters);
            $feedReplies = $stmt->fetchAll();

            try {	    
                if($stmt->rowCount() > 0){   
                    return $feedReplies;	
                } else {
                    return false;
                }

            } catch(PDOException $e) {
                echo $e->getMessage();
            }

        }



        public function getPref($user_id)
        {
            $sql = "SELECT * FROM preferences WHERE user_id = :id";
            $stmt = $this->db->prepare($sql);
            $parameters = [
                ':id'    => $user_id,
            ];

            // echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters);  exit();


            $stmt->execute($parameters);
            $pref = $stmt->fetch();

            try {	    
                if($stmt->rowCount() > 0){   
                    return $pref;	
                } else {
                    return false;
                }

            } catch(PDOException $e) {
                echo $e->getMessage();
            }
        }


        public function updatePref($radius, $user_id)
        {
            $sql = "UPDATE preferences 
                    SET radius = :radius
                    WHERE user_id = :id";
            $stmt = $this->db->prepare($sql);
            $parameters = [
                ':radius'    => $radius,
                ':id'    => $user_id,
            ];

            // echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters);  exit();


            $stmt->execute($parameters);

            try {	    
                if($stmt->rowCount() > 0){   
                    return true;	
                } else {
                    return false;
                }

            } catch(PDOException $e) {
                echo $e->getMessage();
            }
        }

        public function SetPref($user_id)
        {
            $sql = "INSERT INTO preferences (user_id) 
                    VALUES (:user_id)";
            $stmt = $this->db->prepare($sql);
            $parameters = array(
                ':user_id'    => $user_id,
            );

            // echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters);  exit();


            $stmt->execute($parameters);

            try {	    
                if($stmt->rowCount() > 0){   
                    return true;	
                } else {
                    return false;
                }

            } catch(PDOException $e) {
                echo $e->getMessage();
            }
        }


        public function putPost($post, $file_name, $lat, $lon, $tags)
        {
            $id = $_SESSION['user_session']->id;
            $sql = "INSERT INTO posts (user_id, content, post_image, lat, lon) VALUES (:user_id, :content, :file_name, :lat, :lon)";
            $query = $this->db->prepare($sql);
            $parameters = array(':user_id' => $id, ':content' => $post, ':file_name' => $file_name, ':lat' => $lat, ':lon' => $lon);

            // echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters);  exit();

            $query->execute($parameters);
            

            try {	    
                if($query->rowCount() > 0){   
                    if($tags > 0){
                        $post_id = $this->db->lastInsertId();
                        $this->putTags($tags, $post_id);
                    }
                } else {
                    return false;
                }

            } catch(PDOException $e) {
                echo $e->getMessage();
            }
        }

        public function putTags($tag_id, $post_id)
        {

            $sql = "INSERT INTO tags___posts (tag_id, post_id) VALUES (:tag_id, :post_id)";
            $query = $this->db->prepare($sql);
            $parameters = array(':tag_id' => $tag_id, ':post_id' => $post_id );

            // echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters);  exit();

            $query->execute($parameters);

            try {	    
                if($query->rowCount() > 0){   
                    return true;
                } else {
                    return false;
                }

            } catch(PDOException $e) {
                echo $e->getMessage();
            }
        }

        public function putReply($reply, $post_id)
        {
            $id = $_SESSION['user_session']->id;
            $sql = "INSERT INTO post_replies (user_id, content, post_id) VALUES (:user_id, :content, :post_id)";
            $query = $this->db->prepare($sql);
            $parameters = array(':user_id' => $id, ':content' => $reply, ':post_id' => $post_id);

            // echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters);  exit();

            $query->execute($parameters);

            try {	    
                if($query->rowCount() > 0){   
                    return true;	
                } else {
                    return false;
                }

            } catch(PDOException $e) {
                echo $e->getMessage();
            }
        }





        public function deleteReply($id)
        {
            $user_id = $_SESSION['user_session']->id;
            $sql = "DELETE from post_replies WHERE id = :id AND user_id = :user_id";
            $query = $this->db->prepare($sql);
            $parameters = array(':id' => $id, ':user_id' => $user_id);

            // echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters);  exit();

            $query->execute($parameters);
            try {	    
                if($query->rowCount() > 0){   
                    return true;	
                } else {
                    return false;
                }

            } catch(PDOException $e) {
                echo $e->getMessage();
            }
        }


        public function deletePost($id)
        {
            $user_id = $_SESSION['user_session']->id;
            $sql = "DELETE from posts WHERE id = :id AND user_id = :user_id";
            $query = $this->db->prepare($sql);
            $parameters = array(':id' => $id, ':user_id' => $user_id);

            // echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters);  exit();

            $query->execute($parameters);
            try {	    
                if($query->rowCount() > 0){   
                    return true;	
                } else {
                    return false;
                }

            } catch(PDOException $e) {
                echo $e->getMessage();
            }
        }


    public function renameImage($newFileName)
    {
        $user_id = $_SESSION['user_session']->id;
        $sql = "UPDATE users SET image = :newFileName WHERE id = :user_id";
        $query = $this->db->prepare($sql);
        $parameters = array(':newFileName' => $newFileName, ':user_id' => $user_id);

        // echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters);  exit();

        $query->execute($parameters);
        try {	    
            if($query->rowCount() > 0){   
                return true;	
            } else {
                return false;
            }

        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }
}