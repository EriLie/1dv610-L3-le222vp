<?php

require_once('model/UserStorageModel.php');
require_once('controller/MainController.php');
require_once('view/LayoutView.php');
require_once('view/LoginView.php');
require_once('view/DateTimeView.php');
require_once('view/RegisterView.php');

//include 'view/LoginView.php';




class Application {
    
    //CREATE OBJECTS OF THE VIEWS
    private $logInV;
    private $dateV;
    private $layoutV;
    private $registerV;

    private $userStorage; 
     
    private $isLoggedIn;
    private $newUserRegister;

    public function __construct($settings) {
        $this->userStorage = new \Model\UserStorageModel($settings);

        $this->logInV = new \View\LoginView();
        $this->dateV = new \View\DateTimeView();
        $this->layoutV = new \View\LayoutView();
        $this->registerV = new \View\RegisterView();
		//$this->storage = new \Model\UserStorage($settings);
		//$this->user = $this->storage->loadUser();
	
    }
    
	public function run() {
		$this->changeState();
		$this->generateOutput();
    }
    
	private function changeState() {
		//$this->logInV->response($isLoggedIn);
		
    }
    
	private function generateOutput() {
       

		$this->layoutV->render(
            $this->isLoggedIn, 
            $this->logInV, 
            $this->dateV, 
            $this->registerV, 
            $this->newUserRegister
        );
		
		//$pageView = new \View\HTMLPageView($title, $body);
		//$pageView->echoHTML();
	}
}