<?php

namespace View;

class LoginView {
    private static $submitLogin = 'LoginView::Login';
	private static $logout = 'LoginView::Logout';
	private static $name = 'LoginView::UserName';
	private static $password = 'LoginView::Password';
	private static $cookieName = 'LoginView::CookieName';
	private static $cookiePassword = 'LoginView::CookiePassword';
	private static $keep = 'LoginView::KeepMeLoggedIn';
	private static $messageId = 'LoginView::Message';

	private $message = '';
	
    private $inputPostName = '';
    private $hashPassword = '';

    public function checkPost() {
        $this->submitPost();
    }

    private function submitPost() {
        if(isset($_POST[self::$submitLogin])) {
            $nameIsSet = $this->handleUsernamePost();
            $passwordIsSet = $this->handlePasswordPost();
        }
    }
    
    private function handleUsernamePost() {
        $user = $_POST[self::$name];

        if(empty($user)) {
            $this->message = 'Username is missing';
            return false;
        } else {
            $this->inputPostName = $user;
            return true;
        }
    }

    private function handlePasswordPost() {
        $password = $_POST[self::$password];

        if(empty($password)) {
            $this->message = 'Password is missing';
        } else {
            $this->hashPassword = $password;
        }
    }

    public function controlIfLoggedIn() : bool {
	    $isLoggedIn = false;
        
		 // // inloggad? TODO
        // inloggad med kaka? Anrop 
        // inloggad med session?
			
		
		

		return $isLoggedIn;
	}

    /**
	 * Create HTTP response
	 *
	 * Should be called after a login attempt has been determined
	 *
	 * @return  void BUT writes to standard output and cookies!
	 */
	public function response($isLoggedIn) {
		$response;
	
		if ($isLoggedIn) {
			$response = $this->generateLogoutButtonHTML($this->message);			
		} else {
			$response = $this->generateLoginFormHTML($this->message);
		}
	        
		return $response;
    }
    
    /**
	* Generate HTML code on the output buffer for the logout button
	* @param $message, String output message
	* @return  void, BUT writes to standard output!
	*/
	private function generateLogoutButtonHTML($message) {
		return '
			<form  method="post" >
				<p id="' . self::$messageId . '">' . $message .'</p>
				<input type="submit" name="' . self::$logout . '" value="logout"/>
			</form>
		';
	}
	
	/**
	* Generate HTML code on the output buffer for the logout button
	* @param $message, String output message
	* @return  void, BUT writes to standard output!
	*/
	private function generateLoginFormHTML($message) {
		return '
			<form method="post" > 
				<fieldset>
					<legend>Login - enter Username and password</legend>
					<p id="' . self::$messageId . '">' . $message . '</p>
					
					<label for="' . self::$name . '">Username :</label>
					<input type="text" id="' . self::$name . '" name="' . self::$name . '" value="'. $this->inputPostName .'" />

					<label for="' . self::$password . '">Password :</label>
					<input type="password" id="' . self::$password . '" name="' . self::$password . '" />

					<label for="' . self::$keep . '">Keep me logged in  :</label>
					<input type="checkbox" id="' . self::$keep . '" name="' . self::$keep . '" />
					
					<input type="submit" name="' . self::$submitLogin . '" value="login" />
				</fieldset>
			</form>
		';
	}
}