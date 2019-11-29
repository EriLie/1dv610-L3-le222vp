<?php

namespace Controller;

// require_once('model/UserCredentialsModel.php');
require_once('model/Database.php');
//require_once('model/UserLoginModel.php');
require_once('model/StateModel.php');
require_once('model/CookieModel.php');

class LoginController {
    private $logInView;
    private $cookieModel;
    private $state;

    private $database;

    public function __construct() {
        //$this->logInView = $logInView;
        $this->database = new \Model\Database();
        $this->cookieModel = new \Model\CookieModel();
        $this->state = new \Model\StateModel();
    }

    public function run($logInView) {
        $this->logInView = $logInView;

        if ($this->state->isLoggedIn()) {
            if ($logInView->userClickedLogOut()) {
                $this->logout();
            }
        } else if (!$this->state->isLoggedIn()) {
            if ($logInView->submitPost()) {
                $this->tryLogin();
            }

            if ($logInView->controlIfLoggedInWithCookie()) {
                $this->state->setStateLoggedIn();
            }
        }
    }
    
    public function checkIfLoggedIn() : bool { // ANVÄNDS KANSKE INTE?? Kolla upp!
        $loggedIn = false;
       
        if ($this->state->isLoggedIn()) 
        {
            $loggedIn = true;
        } 
        else if ($this->cookieModel->cookieExists($this->logInView->getCookieName())) 
        {
            
            // TODO
            $this->database->getUserFromCookie();
            // 2. Cookie?
            // - check towards database
            $loggedIn = true;            
        }

        return $loggedIn;
    }

    public function tryLogin() {
     
        if ($this->logInView->handleUsernamePost()) {
            if ($this->logInView->handlePasswordPost()) {
                //$this->logInView->handleKeep(); // TODO WHAT?

                $successfullLogin = $this->database->isAuthenticatedUser(
                    $this->logInView->getUsername(), 
                    $this->logInView->getPassword(), 
                    $this->logInView->isKeepPost()
                );
                
                if ($successfullLogin) {
                    $this->logInView->shouldWelcome();
                    $this->state->loggedInUsername($this->logInView->getUsername());
                    $this->state->setHavePrintedWelcome();
                   
                    if ($this->logInView->isKeepPost()) {
                        $this->logInView->setCookie();
                    }
                    
                   
                } else {
                    $this->logInView->handleNameOrPwd();
                }                    
            }
        }
        
        
        
            
            // TODO Do login stuff

            //hända nör det loggat in sätta isloggedIn
            
            // Set Session "state"
            // Set view to say "welcome ..."

            // if ($userLoginModel->isKeepLoggedIn()) {
                // Set cookie
                // set view to say "welcome by cookie"
                
            // }
        
    
    }
    
    public function logout() {
        $this->state->logOut();
    }

    public function getBoolIsLoggedIn() {
        return false;
    }
  
  
}