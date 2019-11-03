<?php

namespace Model;

use Settings;
use StateModel;

class Database {

    private $mysqli;
    private $settings; 
    
    public function __construct() {
        $this->settings = new \Settings(); 

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

        $stmt = $this->mysqli->prepare("SELECT * FROM user WHERE username=? AND hashpassword=?;");
        $stmt->bind_param('ss', $username, $password);
        $stmt->execute();
        
        $stmt->store_result(); // Why?
        
        if ($stmt->num_rows() >= 1) {
            $stateModel = new \Model\StateModel();
            $stateModel->setStateLoggedIn();
            //$stmt->close();
            return true;
        }
        return false;
    }
    
    public function getUserFromCookie($cookieString) {
        // Todo
        return false;
    }
}