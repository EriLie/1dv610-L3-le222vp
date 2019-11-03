<?php

namespace Model;

// Holds login information during log in
class UserLoginModel {
    private $username;
    private $password;
    private $keepLoggedIn;

    public function __construct($username, $password, $keep) {
        // TODO should validate arguments

        $this->username = $username;
        $this->password = $password;
        $this->keepLoggedIn = $keep;
    }

    public function getUsername() {
        return $this->username;
    }

    public function getPassword() {
        return $this->password;
    }

    public function isKeepLoggedIn() {
        return $this->keepLoggedIn;
    }
}