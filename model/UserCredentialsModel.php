<?php

// TODO split this up ino username and password
require_once('UsernameModel.php');
require_once('PasswordModel.php');

class UserCredentialsModel {
    private $username;

    function userCredentialsModel($username) {
        $this->username = $username;
    }

    function getUsername() {
        return $this->username;
    }

    function setUserName($username) {
        $this->username = $username;
    }
}