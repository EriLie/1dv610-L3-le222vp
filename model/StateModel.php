<?php

namespace Model;
// TODO not hardcoded
// Basically sessionModel, handles session
class StateModel {

    
    public function setStateLoggedIn() {
        $_SESSION['userLoggedIn'] = true;
    }

    public function userExist() {
        $_SESSION['userExist'] = true;
    }

   
    public function userDoesNotExist() {
        $_SESSION['userExist'] = false;
    }

    public function isLoggedIn() : bool { //old name checkIfLoggedIn
        return isset($_SESSION['userLoggedIn']);
    }


    public function setHavePrintedWelcome() {
        $_SESSION['shouldNotPrintWelcome'] = true;
    }

    public function havePrintedWelcome() : bool {
        return isset($_SESSION['shouldNotPrintWelcome']);
    }

    public function logOut() {
        unset($_SESSION['userLoggedIn']);
    }

    public function checkIfUserWantsToRegister() : bool {
        return isset($_GET['register']);
    }
}
