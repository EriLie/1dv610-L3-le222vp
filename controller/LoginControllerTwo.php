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
    private $state;

    private $database;

    public function __construct($logInView) {
        $this->logInView = $logInView;
        $this->database = new \Model\Database();
        $this->cookieModel = new \Model\CookieModel();
        $this->state = new \Model\StateModel();
        /*
            X - Kolla session login -> "SessionModel" -> StateModel

            X - kolla cookie login -> CookieModel

            - Logga in ifall användare vill logga in
            - Logga ut ifall användare vill logga ut
            - Måste ha en databaskoppling eller åtminstone Data Access Object -> INGEN ARRAY!!!
            
            
        */

    }
    
    public function checkIfLoggedIn() : bool{
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
        if ($this->logInView->submitPost()) {  
            
            if ($this->logInView->handleUsernamePost()) {
                if ($this->logInView->handlePasswordPost()) {
                    $this->logInView->handleKeep();

                    $this->database->isAuthenticatedUser(
                        $this->logInView->getUsername(), 
                        $this->logInView->getPassword(), 
                        $this->logInView->isKeepPost()
                    );
                        
                    $this->logInView->handleNameOrPwd();
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
    }
    
    public function logout() {
        $this->state->logOut();
    }

    public function getBoolIsLoggedIn() {
        return false;
    }
  
  
}