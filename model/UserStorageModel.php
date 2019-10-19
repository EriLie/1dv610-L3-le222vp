<?php

namespace Model;

class UserStorageModel {
    
    public function __construct($settings) {
        
    }
    
    public function logIn($username, $password) {

    }


	public function loadUser() {
		
    }
    
	public function saveUser(UserName $toBeSaved) {
		
	}

}

/*
//Connect with database
$config = include('settings.php');
$connect = mysqli_connect($config->host, $config->username, $config->password, $config->database);
//$conn = mysqli_connect("localhost", "xampp", "test1234", "user");

if($connect) {
    echo "databas connected";
}

// write a query
$sql = 'SELECT id, username, hashpassword FROM user';

// make a query ang get result
$result = mysqli_query($connect, $sql);

// Fix assorted array
$allUsers = mysqli_fetch_all($result, MYSQLI_ASSOC);
// TODO dölja i klass
//print_r($allUsers);

// free result from memory
mysqli_free_result($result);

// close the conection
mysqli_close($connect);

foreach($allUsers as $user) {
    echo '<h1>' . $user['username'] . '<h1>';
   
}
*/