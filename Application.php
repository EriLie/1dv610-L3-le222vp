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
    
    //CREATE OBJECTS OF THE VIEWS
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
        $this->loginController = new \Controller\LoginController($this->logInView);  
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

        if (!$this->state->isLoggedIn()) {
            // Kolla inloggning med cookies
            $tryToRegister = $this->registerController->checkRegistrationPost();
             
            if ($this->logInView->submitPost()) {
                $this->loginController->tryLogin();
            } 

            if ($this->logInView->controlIfLoggedInWithCookie()) {
                $this->state->setStateLoggedIn();
            }

        } else if ($this->state->isLoggedIn()) {
            if ($this->logInView->userClickedLogOut()) {
                $this->loginController->logout();
            }
            
            // TODO om nytt inlägg POST
            if ($this->noteView->addNewNotePost()) {
                $this->noteController->saveAddedNote($this->noteView);
            }

            // TODO om deleta inlägg POST
            if ($this->noteView->deleteNotePost()) {
                $this->noteController->deleteOneNote($this->noteView);
            }
            
        }

        $this->isLoggedIn = $this->state->isLoggedIn();
		$this->goToRegister = $this->logInView->checkIfUserWantsToRegister();
    }
    
	private function generateOutput() {
        //skapa layout här coh skicka in data i konstructorn??

        if ($this->isLoggedIn) {

        }

        $this->layoutView->render(
                $this->isLoggedIn,
                $this->logInView, 
                $this->dateView, 
                $this->registerView, 
                $this->goToRegister,
                $this->noteView
        );

        // TODO Instead of one render with TO MANY arguments...
        /* 
        if ($this->isLoggedIn) {
            // Gå till loggedIn view
        } else if ($this->goToRegister) {
            // go to register view
        } else {
            // go to log in view
        }
        */
	}
}