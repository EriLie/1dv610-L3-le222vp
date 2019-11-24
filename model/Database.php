<?php

namespace Model;

use Settings;
use StateModel;

class Database {

    private $mysqli;
    private $settings; 
    private $state;


    public function __construct() {
        $this->settings = new \Settings(); 
        $this->state = new \Model\StateModel();

        $this->mysqli = new \mysqli( 
            $this->settings->host, 
            $this->settings->username, 
            $this->settings->password, 
            $this->settings->database
        );

        if ($this->mysqli->connect_errno) {
            // Failure?
            //echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
        }
    }

    public function isAuthenticatedUser($username, $password) : bool {

        $stmt = $this->mysqli->prepare("SELECT * FROM user WHERE BINARY username=? AND BINARY hashpassword=?;");
        $stmt->bind_param('ss', $username, $password);
        $stmt->execute();
        
        $stmt->store_result(); // Why?
        
        if ($stmt->num_rows() >= 1) {
            
            $this->state->setStateLoggedIn();
            //$stmt->close();
            return true;
        } else {
           // $this->checkIfUserExist(); behövs kanske inte?
        }
        return false;
    }

    public function saveUser($name, $pwd) {        
        $stmt = $this->mysqli->prepare("INSERT INTO user (username, hashpassword) VALUES (?, ?);");
        $stmt->bind_param('ss', $name, $pwd);
        $stmt->execute();
    }

    public function checkIfUserExist($username) : bool { 
        $stmt = $this->mysqli->prepare("SELECT * FROM user WHERE username=?;");
        $stmt->bind_param('s', $username);
        $stmt->execute();

        $stmt->store_result();

        if ($stmt->num_rows() >= 1) {
            $this->state->setUserExistTrue();
            return true;
        } else {
            $this->state->setUserExistFalse();
            return false;
        }       
    }

    public function getUserFromCookie($cookieString) {
        // Todo
        return false;
    }
}