<?php

namespace Controller;

require_once('model/Database.php');
require_once('model/StateModel.php');

class LoginController {
    private $logInView;
    private $state;
    private $database;

    public function __construct() {
        $this->database = new \Model\Database();
        $this->state = new \Model\StateModel();
    }

    public function run($logInView) {
        $this->logInView = $logInView;

        if ($this->state->isLoggedIn()) {
            if ($logInView->userClickedLogOut()) {
                $this->logout();
            }
        } else {
            if ($logInView->submitPost()) {
                $this->tryLogin();
            }

            if ($logInView->controlIfLoggedInWithCookie()) {
                $this->state->setStateLoggedIn();
            }
        }
    }

    private function tryLogin() {
        if ($this->logInView->handleUsernamePost()) {
            if ($this->logInView->handlePasswordPost()) {

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
    }
    
    private function logout() {
        // TODO should also remove cookie
        $this->state->logOut();
    }
}