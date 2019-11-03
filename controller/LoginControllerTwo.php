<?php

namespace Controller;

// require_once('model/UserCredentialsModel.php');
require_once('model/Database.php');
require_once('model/UserLoginModel.php');
require_once('model/StateModel.php');
require_once('model/CookieModel.php');

class LoginControllerTwo {
    private $logInView;
    private $cookieModel;
    private $stateModel;

    private $database;

    public function __construct($logInView) {
        $this->logInView = $logInView;
        $this->database = new \Model\Database();
        $this->cookieModel = new \Model\CookieModel();
        $this->stateModel = new \Model\StateModel();
        /*
            X - Kolla session login -> "SessionModel" -> StateModel

            X - kolla cookie login -> CookieModel

            - Logga in ifall användare vill logga in
            - Logga ut ifall användare vill logga ut
            - Måste ha en databaskoppling eller åtminstone Data Access Object -> INGEN ARRAY!!!
            
            
        */

    }
    
    public function checkIfLoggedIn() {
        $loggedIn = false;
       
        if ($this->stateModel->isLoggedIn()) 
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

        if ($this->logInView->submitPost()) {
            $loggedIn = $this->tryLogin();
        }

        return $loggedIn;
    }

    public function tryLogin() {
        if ($this->logInView->submitPost()) {
            $this->logInView->handleUsernamePost();
            $this->logInView->handlePasswordPost();
            $this->logInView->handleKeep();
            //$userLoginModel = new \Model\UserLoginModel(
              //  $this->logInView->getUsername(), 
                //$this->logInView->getPassword(), 
                //$this->logInView->isKeepPost()
           // );
            
            $this->database->isAuthenticatedUser(
                $this->logInView->getUsername(), 
                $this->logInView->getPassword(), 
                $this->logInView->isKeepPost()
            );
           
                
                // TODO Do login stuff

                //hända nör det loggat in sätta isloggedIn
                
                // Set Session "state"
                // Set view to say "welcome ..."

               // if ($userLoginModel->isKeepLoggedIn()) {
                    // Set cookie
                    // set view to say "welcome by cookie"
                    
               // }
           
        } 
    }
    
    public function logout() {
        return false;
    }

    public function getBoolIsLoggedIn() {
        return false;
    }
  
  
}