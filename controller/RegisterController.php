<?php

namespace Controller;

require_once('model/Database.php');

class RegisterController {

    private $registerView;
    private $registerModel;
    private $database;

    private $nameTaken = false;
    private $nameOK = false;
    private $passwordOK = false;
    

    public function __construct($registerView, $registerModel) {
        $this->registerView = $registerView;
        $this->registerModel = $registerModel;
        $this->database = new \Model\Database();
    }

    public function checkRegistrationPost() {
          
        if ($this->registerView->addRegPost()) {
           
            if ($this->registerView->usernamePost()) {
                $name = $this->registerView->getNewUsername();

                if ($this->checkIfUsernameTaken($name)) {
                    $this->nameTaken = true;
                } else {
                    if ($this->registerModel->usernameOkLength($name)) {
                        $this->nameOK = true;
                    }                
                }
            }

            if($this->registerView->pwdPost()) {
                $newpassword = $this->registerView->getPwd();
                
                //var_dump($this->registerView->getPwd());
                if ($this->registerModel->passwordOkLength($newpassword)) {
                    
                    if ($this->registerView->pwdRepeatPost()) {
                        $repeatPassword = $this->registerView->getPwdRepeat();

                        if ($newpassword == $repeatPassword) {
                            $this->passwordOK = true;
                        }
                    }
                }
            }

            if ($this->nameOK && $this->passwordOK) {
                
                //add new user TODO
                $this->database->saveUser($this->registerView->getNewUsername(), $this->registerView->getPwd());
                // TODO sätta session för ny registrering i view $this->
            } else {
               
                $this->registerView->createMessage($this->nameTaken);
            }
        }
        
    }

    public function checkIfUsernameTaken($name) : bool {
        $nameTaken = $this->database->checkIfUserExist($name);

        if($nameTaken) {
            return true;
        } else {
            return false;
        }
    }
    
}
