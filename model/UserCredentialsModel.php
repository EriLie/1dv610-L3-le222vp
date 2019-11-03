<?php

namespace Model;

// TODO split this up ino username and password
//require_once('UsernameModel.php');
//require_once('PasswordModel.php');
require_once('UserStorageModel.php');
require_once('StateModel.php');

// TODO change to controller for USerStorage?

class UserCredentialsModel {
    private $userStorage;
    private $state;

    public function __construct() {
        $this->userStorage = new UserStorageModel();
        $this->state = new StateModel();
    }

    public function userExist($username) : bool {
        return $this->userStorage->usernameExist($username);
    }

    public function passwordExist($pwd) : bool {
        return $this->userStorage->passwordExist($pwd);
    }

    public function tryToLogIn($username, $password) : bool {
        $userCanLogIn = $this->userStorage->isAuthenticatedUser($username, $password);
  
        if ($userCanLogIn) {
            $this->state->setStateLoggedIn();
            //$_SESSION['userLoggedIn'] = true;
            
            return $this->state->checkIfLoggedIn();
        } else {
            return false;
        }
    }

    public function isLoggedInWithSession() : bool {
        return $this->state->checkIfLoggedIn();        
    }

    public function logoutSession() {
        unset($_SESSION['userLoggedIn']);
    }

    public function addUser($name, $pwd) {
        $this->userStorage->saveUser($name, $pwd);
    }
}