<?php

namespace Model;
// TODO not hardcoded, should be static variables
// Basically sessionModel, handles session
class StateModel {

    
    public function setStateLoggedIn() {
        $_SESSION['userLoggedIn'] = true;
    }

    public function setUserExist($bool) {
        $_SESSION['userExist'] = $bool;
    }

    public function userExist() : bool {
        return isset($_SESSION['userExist']);
    }

    public function isLoggedIn() : bool {
        return isset($_SESSION['userLoggedIn']);
    }

    public function loggedInUsername($username) {
        $_SESSION['loggedInUsername'] = $username;
    }

    public function setHavePrintedWelcome() {
        $_SESSION['shouldNotPrintWelcome'] = true;
    }

    public function havePrintedWelcome() : bool {
        return isset($_SESSION['shouldNotPrintWelcome']);
    }

    public function logOut() {
        unset($_SESSION['userLoggedIn']);
        unset($_SESSION['loggedInUsername']);
    }

    public function checkIfUserWantsToRegister() : bool { //TOGO WHY GET???
        return isset($_GET['register']);
    }
}
