<?php

require_once('controller/RegisterController.php');
require_once('controller/LoginController.php');
require_once('controller/NoteController.php');

require_once('view/LayoutView.php');
require_once('view/LoginView.php');
require_once('view/DateTimeView.php');
require_once('view/RegisterView.php');
require_once('view/NoteView.php');

require_once('model/RegisterModel.php');
require_once('model/StateModel.php');

class Application {
    private $logInView;
    private $dateView;
    private $layoutView;
    private $registerView;
    private $noteView;
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
        $this->noteView = new \View\NoteView();

        $this->registerModel = new \Model\RegisterModel();
        $this->state = new \Model\StateModel();

        $this->registerController = new \Controller\RegisterController($this->registerView, $this->registerModel);
        $this->loginController = new \Controller\LoginController();  
        $this->noteController = new \Controller\NoteController();   
    }
    
	public function run() {
        try {
            $this->changeState();
		    $this->generateOutput();
        }
        catch (\Exception $e) {
            echo $e->getMessage();
        }		
    }
    
	private function changeState() {
        $this->registerController->checkRegistrationPost();

        $this->loginController->run($this->logInView);
        $this->noteController->run($this->noteView);

        $this->isLoggedIn = $this->state->isLoggedIn();
		$this->goToRegister = $this->logInView->checkIfUserWantsToRegister();
    }
    
	private function generateOutput() {
        // TODO NOT OK with so many arguments... It's really bad...
        $this->layoutView->render(
                $this->isLoggedIn,
                $this->logInView, 
                $this->dateView, 
                $this->registerView, 
                $this->goToRegister,
                $this->noteView
        );
	}
}