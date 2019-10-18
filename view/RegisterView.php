<?php

class RegisterView {
    private static $username = 'RegisterView::UserName';
	private static $newMessage = 'RegisterView::Message';
	private static $password = 'RegisterView::Password';
	private static $copyPassword = 'RegisterView::PasswordRepeat';
	private static $addRegistration = 'RegisterView::Register';

    private $message = '';
    private $minCharUsername = 3;
    private $minCharpassword = 6;

    public function response($message) {
        $this->userRegistration();

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

    private function userRegistration() {
        $this->message = '';

        if(isset($_POST[self::$addRegistration])) {
            if(strlen($_POST[self::$username]) < $this->minCharUsername) {
                $this->message .= 'Username has too few characters, at least 3 characters. <br>';
            }

            if(strlen($_POST[self::$password]) < $this->minCharpassword) {
                $this->message .= 'Password has too few characters, at least 6 characters. <br>';
            }

            if($_POST[self::$username] == 'Admin' || $_POST[self::$username] == '') {
                $this->message .= 'User exists, pick another username.<br>';
            }
            
        }

    }

}
