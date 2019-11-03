<?php

namespace Controller;

require_once('model/UserCredentialsModel.php');
require_once('model/UserLoginModel.php');

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
        
        if ($userSubmitted) {
            $this->handleLoginSubmit();
        } else if ($userLogOut) {
            $this->userCredentials->logoutSession();
        } 
    }

    private function handleLoginSubmit() {      

        if ($this->logInView->handleUsernamePost() && $this->logInView->handlePasswordPost()) {
            
            $newUser = new \Model\UserLoginModel($this->logInView->getUsername(),
                                                 $this->logInView->getPassword(),
                                                 $this->logInView->isKeepPost());
            
            /*
            $username = $this->logInView->getUsername();
            $pwd = $this->logInView->getPassword();
            /* */
            $nameIsSet = $this->userCredentials->userExist($newUser->getUsername());
            $passwordIsSet = $this->userCredentials->passwordExist($newUser->getPassword());
            /* */

            // Kollar att användaren existerar innan vi loggar in?
            if ($nameIsSet && $passwordIsSet) {
                $userKeep = $this->logInView->iskeepPost();
                $couldLogIn = $this->userCredentials->tryToLogIn($newUser->getUsername(), $newUser->getPassword());
                
                if ($couldLogIn) {
                    $this->logInView->shouldWelcome();
                    $this->logInView->handleKeep();
                }
                
            } else if ($nameIsSet || $passwordIsSet) {
                $this->logInView->handleNameOrPwd();
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