<?php

namespace Controller;

require_once('model/UserCredentialsModel.php');

class RegisterController {

    private $registerView;
    private $registerModel;
    private $userCredentials;

    private $nameTaken = false;
    private $nameOK = false;
    private $passwordOK = false;
    

    public function __construct($registerView, $registerModel) {
        $this->registerView = $registerView;
        $this->registerModel = $registerModel;
        $this->userCredentials = new \Model\UserCredentialsModel();
    }

    public function checkIfAnyPost() {
        //$addRegPost = $this->registerView->addRegPost();
       
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
                $this->userCredentials->addUser($this->registerView->getNewUsername(), $this->registerView->getPwd());
                // TODO sätta session för ny registrering i view $this->
            } else {
                $this->registerView->createMessage($this->nameTaken);
            }  
        }
        
    }

    public function checkIfUsernameTaken($name) : bool {
        //$this->userCredentials->userExist($nameTaken) ? true : false;
        //$name = $this->registerView->getNewUsername();
        $nameTaken = $this->userCredentials->userExist($name);

        if($nameTaken) {
            return true;
        } else {
            return false;
        }
    }
    
}
