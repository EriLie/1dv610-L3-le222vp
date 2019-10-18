<?php

require_once('model/GetDataFromDB.php');
require_once('controller/MainController.php');
require_once('view/LayoutView.php');

//MAKE SURE ERRORS ARE SHOWN... MIGHT WANT TO TURN THIS OFF ON A PUBLIC SERVER
error_reporting(E_ALL);
ini_set('display_errors', 'On');

session_start();

//CREATE OBJECTS OF THE VIEWS
$v = new LoginView();
$dtv = new DateTimeView();
$lv = new LayoutView();
$regV = new RegisterView();

// Skapa controller controller(model, view)


/*controller, kolla state, kolla input, ev ändra state

rendera? 

*/
//echo "här kommer med";