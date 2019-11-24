<?php

require_once('controller/RegisterController.php');
require_once('controller/LoginController.php');

require_once('view/LayoutView.php');
require_once('view/LoginView.php');
require_once('view/DateTimeView.php');
require_once('view/RegisterView.php');
require_once('view/ThoughtView.php');

require_once('model/RegisterModel.php');
require_once('model/StateModel.php');

class Application {
    
    //CREATE OBJECTS OF THE VIEWS
    private $logInView;
    private $dateView;
    private $layoutView;
    private $registerView;
    private $thoughtView;
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
        $this->thoughtView = new \View\ThoughtView();

        $this->registerModel = new \Model\RegisterModel();
        $this->state = new \Model\StateModel();

        $this->registerController = new \Controller\RegisterController($this->registerView, $this->registerModel);
        $this->loginController = new \Controller\LoginController($this->logInView);       
    }
    
	public function run() {        
		$this->changeState(); 
		$this->generateOutput(); 
    }
    
	private function changeState() {

        if (!$this->state->isLoggedIn()) {
            // Kolla inloggning med cookies
            $tryToRegister = $this->registerController->checkRegistrationPost();
             

            if ($this->logInView->submitPost()) {
                $this->loginController->tryLogin();
            } 
        } else if ($this->logInView->userClickedLogOut()) {
            $this->loginController->logout();
        }

        $this->isLoggedIn = $this->state->isLoggedIn();
		$this->goToRegister = $this->state->checkIfUserWantsToRegister();
    }
    
	private function generateOutput() {
        //skapa layout här coh skicka in data i konstructorn??
        $this->layoutView->render(
                $this->isLoggedIn,
                $this->logInView, 
                $this->dateView, 
                $this->registerView, 
                $this->goToRegister,
                $this->thoughtView
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