<?php


require_once('controller/RegisterController.php');
require_once('controller/LoginController.php');

require_once('view/LayoutView.php');
require_once('view/LoginView.php');
require_once('view/DateTimeView.php');
require_once('view/RegisterView.php');

require_once('model/RegisterModel.php');

class Application {
    
    //CREATE OBJECTS OF THE VIEWS
    private $logInView;
    private $dateView;
    private $layoutView;
    private $registerView;
    private $registerModel;
    private $registerController;
     
    private $isLoggedIn;
    private $goToRegister;

    public function __construct() {
        $this->dateView = new \View\DateTimeView();
        $this->layoutView = new \View\LayoutView();
        $this->registerView = new \View\RegisterView();
        $this->logInView = new \View\LoginView();

        $this->registerModel = new \Model\RegisterModel();

        $this->registerController = new \Controller\RegisterController($this->registerView, $this->registerModel);
        $this->loginController = new \Controller\LoginController($this->logInView);

        $this->isLoggedIn = $this->loginController->getBoolIsLoggedIn();        
    }
    
	public function run() {        
		$this->changeState();
		$this->generateOutput();
    }
    
	private function changeState() {
        $this->isLoggedIn = $this->loginController->checkIfLoggedIn();
        $this->goToRegister = $this->layoutView->userWantsToRegister();
        $tryToRegister = $this->registerController->checkIfAnyPost();
		//$this->newUserRegister = $this->layoutV->checkIfRegisterClicked(); //behöver hitta registrationpost
		
    }
    
	private function generateOutput() {

		$this->layoutView->render(
            $this->isLoggedIn, 
            $this->logInView, 
            $this->dateView, 
            $this->registerView, 
            $this->goToRegister
        );
		
		//$pageView = new \View\HTMLPageView($title, $body);
		//$pageView->echoHTML();
	}
}