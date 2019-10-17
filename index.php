<?php

//INCLUDE THE FILES NEEDED...
require_once('view/LoginView.php');
require_once('view/DateTimeView.php');
require_once('view/LayoutView.php');
require_once('view/RegisterView.php');
require_once('settings.php');


//MAKE SURE ERRORS ARE SHOWN... MIGHT WANT TO TURN THIS OFF ON A PUBLIC SERVER
error_reporting(E_ALL);
ini_set('display_errors', 'On');

echo "helo hello hello";
/*
session_start();

//CREATE OBJECTS OF THE VIEWS
$v = new LoginView();
$dtv = new DateTimeView();
$lv = new LayoutView();
$regV = new RegisterView();

$newUserRegister = false;

if(isset($_GET['register'])){
    $_SESSION['newRegister'] = $_GET['register'];
    // rendera register!!!!
    //$regV->render();
    //Blir fel vid Tjo får se vad det kan va
    //behöver gå via layoyt för att det ska hamna i bodyn så dra in det i under typ
    $newUserRegister = true;
}


$isLoggedIn = $v->controlIfLoggedIn();

$lv->render($isLoggedIn, $v, $dtv, $regV, $newUserRegister);

//Connect with database
/*$config = include('settings.php');
$connect = mysqli_connect($config->host, $config->username, $config->password, $config->database);
*/


if (isset($_SESSION['userLoggedIn'])) {
    
    $lv->render(true, $v, $dtv, $regV);

} else if (!isset($_SESSION['userLoggedIn'])) {
    $lv->render(false, $v, $dtv, $regV);
}





*/







//$_SESSION['userLoggedIn'];






//$regV->print();

//$lv->render(false, $v, $dtv, $regV);

