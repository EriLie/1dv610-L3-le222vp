<?php

//MAKE SURE ERRORS ARE SHOWN... MIGHT WANT TO TURN THIS OFF ON A PUBLIC SERVER
error_reporting(E_ALL);
ini_set('display_errors', 'On');

require_once("Application.php");
require_once("Settings.php");

session_start();
//$settings = new Settings();

$app = new Application();
$app->run();



// TODO should not be hardcoded!
//$isLoggedIn = false; // should get in från UserCredentialsModel

// Skapa MasterController, controller(model, view)

// TODO this looks baaaaad
//$layoutV->render($isLoggedIn, $logInV, $dateV, $registerV, $newUserRegister);

/*controller, kolla state, kolla input, ev ändra state

rendera? 

*/
//echo "här kommer med";