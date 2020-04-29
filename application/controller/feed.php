<?php

/**
 * Class Feed
 *
 * Please note:
 * Don't use the same name for class and method, as this might trigger an (unintended) __construct of the class.
 * This is really weird behaviour, but documented here: http://php.net/manual/en/language.oop5.decon.php
 *
 */
class Feed extends Controller
{
    /**
     * PAGE: 
     */
        
        public function index($lat="", $lon="", $post_id="")
        {

            // Login check
            if(!$this->is_loggedin()){
                $this->redirect('user/login');
            }
            $user_id = $_SESSION['user_session']->id;

            if(!$lat || !$lon){
                $this->redirect('problem');
            } 

            // create reply
            if(isset($_POST['reply_submit'])){
                $reply = $this->filterUserInput($_POST['reply_text']);
                $this->model->putReply($reply, $post_id);
            }

             // Update image
            if(isset($_POST['image_upload'])){
                // updateImage paras: file | target path | redirect controller
                $file = $_FILES['user_image']['name'];
                $path = URL . 'public/img/user-imgs';
                $redirect = 'user';
                $error_image_upload = $this->updateImage($file, $path, $redirect);
            }

            // create post
            if(isset($_POST['post_submit'])){

                $post = $this->filterUserInput($_POST['post']);
                $tag_id = $_POST['tags'];
                $error_post = $this->createPost($post, $lat, $lon, $tag_id);
            }

            if(isset($_POST['search_submit'])){
                $search = $this->filterUserInput($_POST['search']);
            } else {
                $search = '';
            }

            // Generate the posts

            $rad = $this->getPref(); // radius of bounding circle in miles

            $R = 3958.8;  // earth's mean radius, miles

            // first-cut bounding box (in degrees)
            $maxLat = $lat + rad2deg($rad/$R);
            $minLat = $lat - rad2deg($rad/$R);
            $maxLon = $lon + rad2deg(asin($rad/$R) / cos(deg2rad($lat)));
            $minLon = $lon - rad2deg(asin($rad/$R) / cos(deg2rad($lat)));

            $feedItems = $this->model->getFeedItems($lat, $lon, $minLat, $minLon, $maxLat, $maxLon, $rad, $R, $search);



            $lat = $lat;
            $lon = $lon;
            

            // load views
            require APP . 'view/_templates/header.php';
            require APP . 'view/feed/index.php';
            require APP . 'view/_templates/footer.php';
        }

        public function deletePost($id){
            $result = $this->model->deletePost($id);
            if($result == true){
                header('Location: '. URL );
            }
        }

        public function deleteReply($id){
            $result = $this->model->deleteReply($id);
            if($result == true){
                header('Location: '. URL );
            }
        }

        public function generateReplies($id)
        {
            $replies = $this->model->getReplies($id);
            echo json_encode($replies);
        }

        public function getPref(){
            $user_id = $_SESSION['user_session']->id;
            $pref = $this->model->getPref($user_id);

            return $pref->radius;
        }



        public function createPost($post, $lat, $lon, $tag_id){

        
            if($_FILES['post_image']['name'] != ''){
                $file = $_FILES['post_image'];
                $target_file = $_FILES['post_image']['name'];
                $target_dir = URL . 'public/';
                $file_name = $this->placeFile($file, $target_file, $target_dir);
            } else {
                $file_name = null;
            }
            
            $this->model->putPost($post, $file_name, $lat, $lon, $tag_id);
        }


}
