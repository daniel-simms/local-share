<?php

/**
 * Class Preferences
 *
 * Please note:
 * Don't use the same name for class and method, as this might trigger an (unintended) __construct of the class.
 * This is really weird behaviour, but documented here: http://php.net/manual/en/language.oop5.decon.php
 *
 */
class Preferences extends Controller
{
    /**
     * PAGE: 
     */
        
        public function index()
        {
            // Login check
            if(!$this->is_loggedin()){
                $this->redirect('user/login');
            }
            $user_id = $_SESSION['user_session']->id;

            // Get Preferences
            $pref = $this->model->getPref($user_id);

            // Update preferences
            if(isset($_POST['update'])){
                $error = $this->model->updatePref($_POST['radius'], $user_id);
                $this->redirect('home');
            }
            // load views
            require APP . 'view/_templates/header.php';
            require APP . 'view/preferences/index.php';
            require APP . 'view/_templates/footer.php';
        }

}
