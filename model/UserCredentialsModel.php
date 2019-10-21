<?php

namespace Model;

// TODO split this up ino username and password
//require_once('UsernameModel.php');
//require_once('PasswordModel.php');
require_once('UserStorageModel.php');

// TODO change to controller for USerStorage?

class UserCredentialsModel {
    private $userStorage;

    public function __construct() {
        $this->userStorage = new UserStorageModel();
    }

    public function userExist($username) : bool {
        return $this->userStorage->usernameExist($username);
    }

    public function passwordExist($pwd) : bool {
        return $this->userStorage->passwordExist($pwd);
    }

    public function tryToLogIn($username, $password) : bool {
        $userCanLogIn = $this->userStorage->authenticateUser($username, $password);
  
        if($userCanLogIn) {
            $_SESSION['userLoggedIn'] = true;
            return true;
        } else {
            return false;
        }
    }

    public function isLoggedInWithSession() : bool {

        if(isset($_SESSION['userLoggedIn'])) {
            return true;
        } else {
            return false;
        }
    }

    public function logoutSession() {
        unset($_SESSION['userLoggedIn']);
    }

    public function addUser($name, $pwd) {
        $this->userStorage->saveUser($name, $pwd);
    }
}