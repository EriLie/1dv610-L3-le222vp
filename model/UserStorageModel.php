<?php

namespace Model;
use Settings;
//require_once('../Settings.php');

class UserStorageModel {
    private $sessionLoggedIn = false;
    private $settings;

    private $connect;
    private $sql;
    private $stmt;
    private $resultUser;
    private $resultPassword;



    
    public function __construct() {
        $this->settings = new \Settings();        
    }

    public function authenticateUser($username, $password) : bool {
        $authenticatedUser = false;

        $this->connectToDb();

        $this->sql = "SELECT * FROM user WHERE username=? AND hashpassword=?;";
        $this->stmt = mysqli_stmt_init($this->connect);

        if(mysqli_stmt_prepare($this->stmt, $this->sql)) {
            mysqli_stmt_bind_param($this->stmt, "ss", $username, $password);
            mysqli_stmt_execute($this->stmt);
            $this->resultUser = mysqli_stmt_get_result($this->stmt);
            if ($user = mysqli_fetch_assoc($this->resultUser)) {
                if($user['username'] == $username && $user['hashpassword'] == $password) {
                    return true;
                }
            } else {
                return false;
            }            
        } else {
            return false;
        }

        mysqli_free_result($this->resultUser);
        mysqli_close($this->connect);

        return $authenticatedUser; 
    }

    public function usernameExist($username) : bool {
        $this->connectToDb();

        $this->sql = "SELECT * FROM user WHERE username=?;";
        $this->stmt = mysqli_stmt_init($this->connect);
        
        if(mysqli_stmt_prepare($this->stmt, $this->sql)) {
            mysqli_stmt_bind_param($this->stmt, "s", $username);
            mysqli_stmt_execute($this->stmt);
            $this->resultUser = mysqli_stmt_get_result($this->stmt);
            if ($user = mysqli_fetch_assoc($this->resultUser)) {
                return $user['username'] == $username ? true : false;
            } else {
                return false;
            }            
        } else {
            return false;
        }
    }

    public function passwordExist($password) : bool {
        $this->connectToDb();

        $this->sql = "SELECT * FROM user WHERE hashpassword=?;";
        $this->stmt = mysqli_stmt_init($this->connect);
        
        if(mysqli_stmt_prepare($this->stmt, $this->sql)) {
            mysqli_stmt_bind_param($this->stmt, "s", $password);
            mysqli_stmt_execute($this->stmt);
            $this->resultUser = mysqli_stmt_get_result($this->stmt);
            if ($user = mysqli_fetch_assoc($this->resultUser)) {
                return $user['hashpassword'] == $password ? true : false;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    
    private function verifyPwd($password) : bool {
        if ($user = mysqli_fetch_assoc($this->resultUser)) {
            //var_dump($user['hashpassword']);
            return $user['hashpassword'] == $password ? true : false;

            // TODO should be with password_hash and password_verify
            //$correctPassword = password_verify($password, $user['hashpassword']);
            //return $correctPassword ? true : false;
        } else {
            return false;
        }
    }

    private function connectToDb() {
        $this->connect = mysqli_connect(
            $this->settings->host, 
            $this->settings->username, 
            $this->settings->password, 
            $this->settings->database
        );

        if($this->connect) {
            //echo "databas connected";
        }
    }

   
    
	public function loadUser() {
		
    }
    
	public function saveUser($name, $pwd) {
        $this->connectToDb();
        
        $sql = "INSERT INTO user (username, hashpassword) VALUES (?,?);";

        $stmt = mysqli_stmt_init($this->connect);
        if (mysqli_stmt_prepare($stmt, $sql)) {
            mysqli_stmt_bind_param($stmt, "ss", $name, $pwd);
            mysqli_stmt_execute($stmt);
        }
    }
    


}

