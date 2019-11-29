<?php

//MAKE SURE ERRORS ARE SHOWN... MIGHT WANT TO TURN THIS OFF ON A PUBLIC SERVER
error_reporting(E_ALL);
ini_set('display_errors', 'On');

require_once("Application.php");
require_once("Settings.php");

session_start();

$app = new Application();
$app->run();

