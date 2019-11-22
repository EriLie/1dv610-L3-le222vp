<?php

require_once('controller/RegisterController.php');
//require_once('controller/LoginController.php');
require_once('controller/LoginControllerTwo.php');

require_once('view/LayoutView.php');
require_once('view/LoginView.php');
require_once('view/DateTimeView.php');
require_once('view/RegisterView.php');

require_once('model/RegisterModel.php');
require_once('model/StateModel.php');

class Application {
    
    //CREATE OBJECTS OF THE VIEWS
    private $logInView;
    private $dateView;
    private $layoutView;
    private $registerView;
    private $registerModel;
    private $registerController;
    private $state;
     
    private $isLoggedIn;
    private $goToRegister;

    public function __construct() {
        $this->dateView = new \View\DateTimeView();
        $this->layoutView = new \View\LayoutView();
        $this->registerView = new \View\RegisterView();
        $this->logInView = new \View\LoginView();

        $this->registerModel = new \Model\RegisterModel();
        $this->state = new \Model\StateModel();

        $this->registerController = new \Controller\RegisterController($this->registerView, $this->registerModel);
        //$this->loginController = new \Controller\LoginController($this->logInView);
        $this->loginController = new \Controller\LoginControllerTwo($this->logInView);

        //$this->isLoggedIn = $this->loginController->getBoolIsLoggedIn();        
    }
    
	public function run() {        
		$this->changeState(); 
		$this->generateOutput(); 
    }
    
	private function changeState() {

        if (!$this->state->isLoggedIn()) {
            // Kolla inloggning med cookies
            $tryToRegister = $this->registerController->checkRegistrationPost();
            $this->goToRegister = $this->state->checkIfUserWantsToRegister(); 

            if ($this->logInView->submitPost()) {
                $this->loginController->tryLogin();
            } 
        } else if ($this->logInView->userClickedLogOut()) {
            // Annars kanske användaren ville logga ut?
            $this->loginController->logout();
        } 
        

        // Here we begin running application 
        // example notes?

        
/* 
        if ($this->state->havePrintedWelcome()) {
            $this->logInView->emptyMessage();
        }
*/        
        
        

        

        $this->isLoggedIn = $this->state->isLoggedIn();
        


// Gå igenom härifrån, kommer dubbelt på nåt sätt, och sen felmeddelanden!!
/*
        if (!$this->isLoggedIn) {
            
        } else if ($this->logInView->userClickedLogOut()) {
            $this->loginController->logout();
        }
 */
        //renderar fel
        
        
        
		//$this->newUserRegister = $this->layoutV->checkIfRegisterClicked(); //behöver hitta registrationpost
		
    }
    
	private function generateOutput() {
        //skapa layout här coh skicka in data i konstructorn??
        $this->layoutView->render(
                $this->isLoggedIn,
                $this->logInView, 
                $this->dateView, 
                $this->registerView, 
                $this->goToRegister
        );

        
        if ($this->isLoggedIn) {
            // Gå till loggedIn view
        } else if ($this->goToRegister) {
            // go to register view
        } else {
            // go to log in view
        }
        
        //$this->logInView->emptyMessage();
	 
		//$pageView = new \View\HTMLPageView($title, $body);
		//$pageView->echoHTML();
	}
}