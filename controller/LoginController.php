<?php

namespace Controller;

require_once('model/UserCredentialsModel.php');

class LoginController {
    private $isLoggedIn = false;

    private $userCredentials;
    private $logInView;

    public function __construct($logInView) {
        $this->userCredentials = new \Model\UserCredentialsModel();
        $this->logInView = $logInView;
        $this->checkIfAnyPost();
        $this->checkIfLoggedIn();
    }
    
    public function getBoolIsLoggedIn() : bool {
        return $this->isLoggedIn;
    }

    private function checkIfAnyPost() {
        $userSubmitted = $this->logInView->submitPost(); 
        $userLogOut = $this->logInView->logoutPost();
        
        if($userSubmitted) {
            $this->handleSubmit();
        } else if ($userLogOut) {
            $this->userCredentials->logoutSession();
        } 
    }

    private function handleSubmit() {
        

        if($this->logInView->handleUsernamePost()) {
            if($this->logInView->handlePasswordPost()) {
                $username = $this->logInView->getUsername();
                $pwd = $this->logInView->getPassword();
                
                $nameIsSet = $this->userCredentials->userExist($username);
                $passwordIsSet = $this->userCredentials->passwordExist($pwd);

                if ($nameIsSet && $passwordIsSet) {
                    $userKeep = $this->logInView->keepPost();
                    $couldLogIn = $this->userCredentials->tryToLogIn($username, $pwd);
                    
                    if ($couldLogIn) {
                        $this->logInView->shouldWelcome();
                        $this->logInView->handleKeep();
                    }
                    
                } else if ($nameIsSet || $passwordIsSet) {
                    $this->logInView->handleNameOrPwd();
                }

            }
        }
    }

    public function checkIfLoggedIn() { 
        if($this->userCredentials->isLoggedInWithSession()) {
            $this->isLoggedIn = true;
            return true;
        } else if ($this->logInView->controlIfLoggedInWithCookie()) {
            $this->isLoggedIn = true;
            return true;
        }
    }

   

}