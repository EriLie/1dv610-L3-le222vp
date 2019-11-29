<?php

namespace View;

require_once('Messages.php');
require_once('model/StateModel.php'); // ? 

// TODO string dependency with POST och GET, make static variables!

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
	
    public function getUsername() {
        return $this->inputPostName;
    }

    public function getPassword() {
        return $this->hashPassword;
	}
	
	public function getCookieName() {
		return self::$cookieName;
	}

	public function submitPost() : bool {
		return isset($_POST[self::$submitLogin]);
	}

    public function checkIfUserWantsToRegister() : bool {
        return isset($_GET['register']);
    }
	
	public function userClickedLogOut() : bool {
		if(isset($_POST[self::$logout])) {
			$this->message = Messages::$bye;
			return true;
		} else {
			return false;
		}
	}

	public function isKeepPost() : bool {
		return isset($_POST[self::$keep]);
	}
    
    public function handleUsernamePost() : bool {
        $user = $_POST[self::$name];

        if(empty($user)) {
            $this->message = Messages::$missingUsername;
            return false;
        } else {
            $this->inputPostName = $user;
            return true;
        }
	}
	
	public function setCookie() {
		$cookieValue = $this->inputPostName;
		setcookie(self::$cookieName, $cookieValue, time() + 3600);
	}

    public function handlePasswordPost() : bool {
        $password = $_POST[self::$password];

        if(empty($password)) {
            $this->message = Messages::$missingPassword;
            return false;
        } else {
            $this->hashPassword = $password;
            return true;
        }
    }

    public function handleNameOrPwd() {
        $this->message = Messages::$pwdOrNameWrong;
	}
	
	public function shouldWelcome() {
		$this->message = Messages::$welcome;
	}

	public function emptyMessage() {
		$this->message = "";
	}

    public function controlIfLoggedInWithCookie() : bool {
	    if (isset($_COOKIE[self::$cookieName])) {
			$this->message = Messages::$welcomeCookie;
			return true;
		} else {
			return false;
		} 
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
			$this->emptyMessage();
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
			<form method="post"> 
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