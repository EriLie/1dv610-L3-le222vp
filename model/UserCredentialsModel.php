<?php

namespace Model;

// TODO split this up ino username and password
require_once('UsernameModel.php');
require_once('PasswordModel.php');
require_once('UserStorageModel.php');

class UserCredentialsModel {
    private $username;
    private $password;

    private $userStorage;

    public function __construct($settings) {
        $this->userStorage = new UserStorageModel($settings);
    }

    function userCredentialsModel($username, $password) {

        $this->username = $username;
        $this->password = $password;
    }

    function getUsername() {
        return $this->username;
    }

    function setUserName($username) {
        $this->username = $username;
    }
}