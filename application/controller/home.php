<?php

/**
 * Class Home
 *
 * Please note:
 * Don't use the same name for class and method, as this might trigger an (unintended) __construct of the class.
 * This is really weird behaviour, but documented here: http://php.net/manual/en/language.oop5.decon.php
 *
 */
class Home extends Controller
{
    /**
     * PAGE: index
     */
        public function index()
        {

            // Load Landing page or geolocation
            require APP . 'view/_templates/header.php';
            if($this->is_loggedin()){
                require APP . 'view/home/geolocation.php';
            } else {
                require APP . 'view/home/landing-page.php';
            }
            require APP . 'view/_templates/footer.php';
        }


}
