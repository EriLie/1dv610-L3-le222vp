<?php

namespace Model;

require_once('model/NoteModel.php');

use Settings;
use StateModel;

// TODO shoud have one class for connect and then different classes for the different tables (notes and users). Not everything is together...
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
            throw new \Exception("Failed to connect to MySQL, action aborted");
        }
    }

    public function isAuthenticatedUser($username, $password) : bool {
        $stmt = $this->mysqli->prepare("SELECT * FROM user WHERE BINARY username=? AND BINARY hashpassword=?;");
        $stmt->bind_param('ss', $username, $password);
        $stmt->execute();
        
        $stmt->store_result();
        
        if ($stmt->num_rows() >= 1) {
            $this->state->setStateLoggedIn();
            return true;
        } else {
            return false;
        }        
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

    public function saveNote($oneNote) {
        $author = $oneNote->getAuthor();
        $title = $oneNote->getTitle();
        $content = $oneNote->getContent();
        $public = $oneNote->getPublic();
        $created  = $oneNote->getCreated();

        $stmt = $this->mysqli->prepare("INSERT INTO notes (author, title, content, public, created) VALUES (?, ?, ?, ?, ?);");
        $stmt->bind_param('sssis', $author, $title, $content, $public, $created);
        $stmt->execute();
    }

    public function deleteNote($id) {
        $stmt = $this->mysqli->prepare("DELETE FROM notes WHERE id=?;");
        $stmt->bind_param('i', $id);
        $stmt->execute();
    }

    // TODO There's a lot of duplicated code and that sucks. Should be severel smaller methods.
    public function getNotesFromLoggedInUser() { 
        $loggedInUser = $this->state->getLoggedInUsername();
        $allNotesFromUser = [];

        $stmt = $this->mysqli->prepare("SELECT id, author, title, content, public, created FROM notes WHERE author=? ORDER BY id DESC;");
        $stmt->bind_param('s', $loggedInUser);
        $stmt->execute();

        $stmt->bind_result($id, $author, $title, $content, $public, $created);

        while ($stmt->fetch()) {            
            $noteObject = new NoteModel($id, $author, $title, $content, $public, $created);
            $allNotesFromUser[] = $noteObject;
        }

        return $allNotesFromUser;
    }

    public function getAllPublicNotes() {
        $allPublicNotes = [];
        $isPublic = true; // The value in the database for public is a boolean and should be true if public

        $stmt = $this->mysqli->prepare("SELECT id, author, title, content, public, created FROM notes WHERE public=? ORDER BY id DESC;");
        $stmt->bind_param('i', $isPublic);
        $stmt->execute();

        $stmt->bind_result($id, $author, $title, $content, $public, $created);

        while ($stmt->fetch()) {            
            $noteObject = new NoteModel($id, $author, $title, $content, $public, $created);
            $allPublicNotes[] = $noteObject;
        }

        return $allPublicNotes;
    }

}