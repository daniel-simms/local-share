<?php

class Controller
{
    /**
     * @var null Database Connection
     */
    public $db = null;

    /**
     * @var null Model
     */
    public $model = null;

    /**
     * Whenever controller is created, open a database connection too and load "the model".
     */
    function __construct()
    {
        $this->openDatabaseConnection();
        $this->loadModel();
        session_start();
    }

    /**
     * Open the database connection with the credentials from application/config/config.php
     */
    private function openDatabaseConnection()
    {
        // set the (optional) options of the PDO connection. in this case, we set the fetch mode to
        // "objects", which means all results will be objects, like this: $result->user_name !
        // For example, fetch mode FETCH_ASSOC would return results like this: $result["user_name] !
        // @see http://www.php.net/manual/en/pdostatement.fetch.php
        $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ, PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING);

        // generate a database connection, using the PDO connector
        // @see http://net.tutsplus.com/tutorials/php/why-you-should-be-using-phps-pdo-for-database-access/
        $this->db = new PDO(DB_TYPE . ':host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET, DB_USER, DB_PASS, $options);
    }

    /**
     * Loads the "model".
     * @return object model
     */
    public function loadModel()
    {
        require APP . 'model/model.php';
        // create new "model" (and pass the database connection)
        $this->model = new Model($this->db);
    }

    /**
     * Check to see if the user is logged in or not
     */

    protected function is_loggedin()
	{
		if(isset($_SESSION['user_session']))
		{
			return true;
		} else {
			return false;
		}
    }
    
    /**
     * Logs the user out
     */

	public function logout($logout)
	{
		session_start();
		if(isset($logout) && $logout=="true"){
				session_destroy();
				unset($_SESSION['user_session']);
				$this->redirect('user/login');
				//return true;
		}
	
	}

    # Sanitising user input

	public function filterUserInput($data) {

		// trim() function will remove whitespace from the beginning and end of string.
		$data = trim($data);

		// Strip HTML and PHP tags from a string
		$data = strip_tags($data);

		/* The stripslashes() function removes backslashes added by the addslashes() function.
			Tip: This function can be used to clean up data retrieved from a database or from an HTML form.*/
		$data = stripslashes($data);

		// htmlspecialchars() function converts special characters to HTML entities. Say '&' (ampersand) becomes '&amp;'
		$data = htmlspecialchars($data);
		return $data;

    } # End of filter_user_input function

    /**
     * Redirects a user to a different page
     */

    public function redirect($url)
	{
		$url = URL.$url;
		header("Location: $url");
    }

    /**
     * Uploads an image to the DB and places it in the public folder
     */

    public function uploadImage($target_file, $target_dir)
    {
        $file_name = $this->placeFile($target_file, $target_dir);
    }

    /**
     * Updates an image on the DB and places it in a folder
     */

    public function updateImage($file, $target_file, $target_dir, $redirect)
    {
        $newFileName = $this->placeFile($file, $target_file, $target_dir);

        if($newFileName != false){
            $this->model->renameImage($newFileName);
            $_SESSION['user_session']->image = $newFileName;
            $this->redirect($redirect);
        }
        
    }

    
    /**
     * Places the image in a file
     */
    
    public function placeFile($file, $target_file, $target_dir){
        //update image
        $user_id = $_SESSION['user_session']->id;
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        $newFileName = SHA1(rand(1,100000)).'.'.$imageFileType;

        // Check if image file is a actual image or fake image
        if(isset($_POST["image_upload"])) {
            $check = getimagesize($_FILES["user_image"]["tmp_name"]);
            if($check !== false) {
                $uploadOk = 1;
            } else {
                echo "File is not an image.";
                $uploadOk = 0;
            }
        }
         // Allow certain file formats
         if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
         && $imageFileType != "gif" ) {
             echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
             $uploadOk = 0;
         }

        // Check if file already exists
        if (file_exists($target_file)) {
            echo "Sorry, file already exists.";
            $uploadOk = 0;
        }
        // Check file size
        if ($file["size"] > 5000000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }
       
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
        // if everything is ok, try to upload file
        } else {
            // Change name to random
            if (move_uploaded_file($file["tmp_name"],$newFileName)) {
                return $newFileName;
            } else {
                return false;
            }
        }

    }
    
}
