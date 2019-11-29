<?php

namespace Model;

class RegisterModel {

    private $minCharUsername = 3; 
    private $minCharPassword = 6;

    public function usernameOkLength($name) : bool {
        if (strlen($name) >= $this->minCharUsername) {
            return true;
        } else {
            return false;
        }
    }

    public function passwordOkLength($password) : bool {
        if (strlen($password) > $this->minCharPassword) {
            return true;
        } else {
            return false;
        }
    }
}
