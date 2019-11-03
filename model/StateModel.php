<?php

namespace Model;
// TODO not hardcoded
// Basically sessionModel, handles session
class StateModel {

    
    public function setStateLoggedIn() {
        $_SESSION['userLoggedIn'] = true;
    }

    public function isLoggedIn() : bool { //old name checkIfLoggedIn
        return isset($_SESSION['userLoggedIn']);
    }

    public function checkIfUserWantsToRegister() : bool {
        return isset($_GET['register']);
    }
}
