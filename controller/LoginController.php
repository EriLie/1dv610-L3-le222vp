<?php

namespace Controller;


require_once('model/UserCredentialsModel.php');

class LoginController {
    private $isLoggedIn = false;

    private $userCredentials;
    private $logInView;

    public function __construct($settings, $logInView) {
        $this->userCredentials = new \Model\UserCredentialsModel($settings);
        $this->logInView = $logInView;
        $this->checkIfAnyPost();
        $this->checkIfLoggedIn();
    }
    
    public function getBoolIsLoggedIn() : bool {
        return $this->isLoggedIn;
    }

    private function checkIfAnyPost() {
       $this->logInView->checkPost();
    }

    private function checkIfLoggedIn() {
       
        $this->isLoggedIn = $this->logInView->controlIfLoggedIn();
    }

    private function login() {
        // TODO log in with authentification
    }

    private function authenticate() {
        // TODO from model
    }

    private function logout() {

    }
}