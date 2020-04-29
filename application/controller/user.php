<?php

/**
 * Class User
 *
 * Please note:
 * Don't use the same name for class and method, as this might trigger an (unintended) __construct of the class.
 * This is really weird behaviour, but documented here: http://php.net/manual/en/language.oop5.decon.php
 *
 */
class User extends Controller
{
    /**
     * PAGE: index
     */

        public function index()
        {
            // Login check
            if(!$this->is_loggedin()){
                $this->redirect('user/login');
            }

            // Update email
            if(isset($_POST['email_change'])){
                $password = $this->filterUserInput($_POST['password_email']);
                $password = sha1($password);
                if($password != $_SESSION['user_session']->password){
                    $error_password_email = "Wrong password";
                } else {
                    $error_email = $this->updateEmail($_POST['email']);
                }
            }

            // Update username
            if(isset($_POST['username_change'])){
                $password = $this->filterUserInput($_POST['password_username']);
                if(sha1($password) != $_SESSION['user_session']->password){
                    $error_password_username = "Wrong password";
                } else {
                    $error_username = $this->updateUsername($_POST['username']);
                }
            }

            // Update details
            if(isset($_POST['details_change'])){
                $password = $this->filterUserInput($_POST['password_datails']);
                if(sha1($password) != $_SESSION['user_session']->password){
                    $error_password_details = "Wrong password";
                } else {
                    $error_details = $this->updateDetails($_POST['firstname'], $_POST['lastname']);
                }
            }

            // Update password
            if(isset($_POST['password_change'])){
                $password = $this->filterUserInput($_POST['current_password']);
                if(sha1($password) != $_SESSION['user_session']->password){
                    $error_password_current_password = "Wrong password";
                } else {
                    $error_new_password = $this->updatePassword($_POST['new_password']);
                }
            }

            // Update image
            if(isset($_POST['image_upload'])){
                // updateImage paras: file | target path | redirect controller
            
                $file = $_FILES['user_image'];
                $target_file = $_FILES['user_image']['name'];
                $target_dir = URL . 'public/';
                $redirect = 'user';
                $error_image_upload = $this->updateImage($file, $target_file, $target_dir, $redirect);
            }


            // load views
            require APP . 'view/_templates/header.php';
            require APP . 'view/user/index.php';
            require APP . 'view/_templates/footer.php';
             

            
        }

        

        public function updateUsername($username){

            //update username
            $username = $this->filterUserInput($username);
            $user_id = $_SESSION['user_session']->id;

            if($username != $_SESSION['user_session']->username){
                if($this->model->checkUsernameExists($username) == true)
                {
                    return $error_username = "Username is already in use.";
                } else {
                    $this->model->updateUsername($username, $user_id);
                    $this->redirect('user/?user=usernameupdate');
                }
            } else {
                $this->model->updateUsername($username, $user_id);
                $this->redirect('user/?user=usernameupdate');
            }

        }

        public function updateEmail($email){

            $email = $this->filterUserInput($_POST['email']);
            $user_id = $_SESSION['user_session']->id;

            if($email != $_SESSION['user_session']->email){
                if($this->model->checkEmailExists($email) == true)
                {
                    return $error_email = "Email is already in use.";
                } else {
                    $this->model->updateEmail($email, $user_id);
                    $this->redirect('user/?user=emailupdate');
                }
            } else {
                $this->model->updateEmail($email, $user_id);
                $this->redirect('user/?user=emailupdate');
            }

        }

        public function updateDetails($firstname, $lastname){

            //update details
            $firstname = $this->filterUserInput($firstname);
            $lastname = $this->filterUserInput($lastname);
            $user_id = $_SESSION['user_session']->id;

            $this->model->updateDetails($firstname, $lastname, $user_id);
            $this->redirect('user/?user=detailsupdate');
        }

        public function updatePassword($password){

            //update password
            $password = $this->filterUserInput($password);
            $password = sha1($password);

            $user_id = $_SESSION['user_session']->id;

            $this->model->updatePassword($password, $user_id);
            $this->redirect('user/?user=passwordupdate');

        }

    /**
     * PAGE: register
     */
        public function register()
        {
            // register form submit
            if(isset($_POST['register'])){
                $error_email = $this->validateRegister();
            }
            
            //if logged in, redirect
            if($this->is_loggedin()){
                $this->redirect('home');
            }
            
            // load views
            require APP . 'view/_templates/header.php';
            require APP . 'view/user/register.php';
            require APP . 'view/_templates/footer.php';
        }

        public function validateRegister(){

            $username = $this->filterUserInput($_POST['username']);
            $firstname = $this->filterUserInput($_POST['firstname']);
            $lastname = $this->filterUserInput($_POST['lastname']);
            $email = $this->filterUserInput($_POST['email']);
            $password = $this->filterUserInput($_POST['password']);

            if($this->model->checkEmailExists($email) == true)
            {
                $error_email = "Email is already in use.";
            } 

            if(isset($error_email)){
                return $error_email;
            } else {
                $id = $this->model->registerUser($username, $firstname, $lastname, $email, $password);
                $this->redirect('user/login');
            }

        }

    /**
     * PAGE: login
     */
        public function login()
        {
            // login form submit
            if(isset($_POST['login'])){
                $error = $this->validateLogin();
            }

            //if logged in, redirect
            if($this->is_loggedin()){
                $this->redirect('home');
            }

            // load views
            require APP . 'view/_templates/header.php';
            require APP . 'view/user/login.php';
            require APP . 'view/_templates/footer.php';
        }

        public function validateLogin(){

            $email = $this->filterUserInput($_POST['email']);
            $password = $this->filterUserInput($_POST['password']);
            
            if(!$this->model->doLogin($email,$password)){
                $error = "Sorry invalid Login details !";
            }

            if(isset($error)){
                return $error;
            } else {
                session_start();
                $_SESSION['user_session'] = $this->model->doLogin($email,$password);
            }

        }

}
