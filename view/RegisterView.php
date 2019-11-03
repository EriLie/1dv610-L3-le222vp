<?php

namespace View;

class RegisterView {
    private static $username = 'RegisterView::UserName';
	private static $newMessage = 'RegisterView::Message';
	private static $password = 'RegisterView::Password';
	private static $copyPassword = 'RegisterView::PasswordRepeat';
	private static $addRegistration = 'RegisterView::Register';

    private $message = '';
    private $minCharUsername = 3; // TODO not hardcoded!
    private $minCharpassword = 6;
    
    private $newUsername;
    private $pwd;
    private $pwdRepeat;

    public function getNewUsername() {
        return $this->newUsername;
    }

    public function getPwd() {
        return $this->pwd;
    }

    public function getPwdRepeat() {
        return $this->pwdRepeat;
    }

    public function response($message) {

        return '
            <h2>Register new user</h2>
            <form action="?register" method="post">
                <fieldset>
                    <legend>Register a new user - Write username and password</legend>
                    <p id="' . self::$newMessage . '">' . $this->message . '</p>                
                    
                    <label for="' . self::$username . '" >Username :</label>
                    <input type="text" size="20" name="'. self::$username .'" id="'. self::$username .'" value="" />
                    
                    <br>
                    
                    <label for="' . self::$password . '">Password :</label>
                    <input type="password" size="20" name="'. self::$password .'" id="' . self::$password . '" value="" />
                    
                    <br>
                    
                    <label for="' . self::$copyPassword .'" >Repeat password :</label>
                    <input type="password" size="20" name="' . self::$copyPassword . '" id="' . self::$copyPassword . '" value="" />
                    
                    <br>
                    
                    <input id="submit" type="submit" name="' . self::$addRegistration . '"  value="Register" />
                    <br>
                </fieldset>
            </form> 
        ';
    }



    public function createMessage($nameTaken) {
        $this->message = '';

        if(isset($_POST[self::$addRegistration])) {
            if(strlen($_POST[self::$username]) < $this->minCharUsername) {

                $this->message .= Messages::$nameToFewChars;
            }

            if(strlen($_POST[self::$password]) < $this->minCharpassword) {
                $this->message .= Messages::$pwdToFewChars;
            }

            if($nameTaken || $_POST[self::$username] == '') {
                $this->message .= Messages::$usernameTaken;
            }

            
            
        }

    }

    public function addRegPost() : bool {
        return isset($_POST[self::$addRegistration]) ? true : false;
    }

    public function usernamePost() : bool {
        if(isset($_POST[self::$username])) {
            $this->newUsername = htmlspecialchars($_POST[self::$username]);
            return true;
        } else {
            return false;
        }
    }

    public function pwdPost() : bool {
        if(isset($_POST[self::$password])) {
            $this->pwd = $_POST[self::$password];
            return true;
        } else {
            return false;
        }
    }

    public function pwdRepeatPost() : bool {
        if(isset($_POST[self::$copyPassword])) {
            $this->pwdRepeat = $_POST[self::$copyPassword];
            return true;
        } else {
            return false;
        }
    }

}
