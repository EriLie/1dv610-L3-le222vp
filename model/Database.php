<?php

namespace Model;

use Settings;
use StateModel;

require_once('model/NoteModel.php');

use \Model\NoteModel;


// TODO shoud have a class for connect and different classes for the different tables
class Database {

    private $mysqli;
    private $settings; 
    private $state;


    public function __construct() {
        $this->settings = new \Settings(); 
        $this->state = new \Model\StateModel();


        try {
            $this->mysqli = new \mysqli( 
                $this->settings->host, 
                $this->settings->username, 
                $this->settings->password, 
                $this->settings->database
            );
        }
        catch (\Exception $e) {
            throw new \Exception("Failed to connect to MySQL, action aborted"); //TODO
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
            $this->state->setUserExist(true);
            return true;
        } else {
            $this->state->setUserExist(false);
            return false;
        }       
    }

    public function getNotesFromLoggedInUser() { 
        $loggedInUser = $this->state->getLoggedInUsername();
        $allNotesFromUser = [];

        $stmt = $this->mysqli->prepare("SELECT id, author, title, content, public, created FROM notes WHERE author=?;");
        $stmt->bind_param('s', $loggedInUser);
        $stmt->execute();

        //$stmt->store_result();
        //var_dump($stmt->store_result()); 
        //printf("Number of rows: %d. \n", $stmt->num_rows);

        // Bind result to variables
        $stmt->bind_result($id, $author, $title, $content, $public, $created);

        while ($stmt->fetch()) {            
            $noteObject = new NoteModel($id, $author, $title, $content, $public, $created);
            $allNotesFromUser[] = $noteObject;
        }

        return $allNotesFromUser;
    }

    public function getUserFromCookie($cookieString) {
        // Todo
        return false;
    }
}