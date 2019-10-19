<?php



require_once('controller/LoginController.php');
require_once('controller/MainController.php');

require_once('view/LayoutView.php');
require_once('view/LoginView.php');
require_once('view/DateTimeView.php');
require_once('view/RegisterView.php');

class Application {
    
    //CREATE OBJECTS OF THE VIEWS
    private $logInView;
    private $dateV;
    private $layoutV;
    private $registerV;

    //private $userStorage; 
     
    private $isLoggedIn;
    private $newUserRegister = false; // TODO

    public function __construct($settings) {
        $this->dateV = new \View\DateTimeView();
        $this->layoutV = new \View\LayoutView();
        $this->registerV = new \View\RegisterView();
        $this->logInView = new \View\LoginView();

        $this->LoginController = new \Controller\LoginController($settings, $this->logInView);

        $this->isLoggedIn = $this->LoginController->getBoolIsLoggedIn();
        
    }
    
	public function run() {
        $this->checkState();        
		$this->changeState();
		$this->generateOutput();
    }

    private function checkState() {
       

    }
    
	private function changeState() {
        
		//$this->logInV->response($isLoggedIn);
		
    }
    
	private function generateOutput() {
       

		$this->layoutV->render(
            $this->isLoggedIn, 
            $this->logInView, 
            $this->dateV, 
            $this->registerV, 
            $this->newUserRegister
        );
		
		//$pageView = new \View\HTMLPageView($title, $body);
		//$pageView->echoHTML();
	}
}