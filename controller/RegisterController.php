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
        $addRegPost = $this->registerView->addRegPost();
       
        if ($addRegPost) {
            $newUsername = $this->registerView->usernamePost();

            if ($newUsername) {
                if ($this->checkIfUsernameTaken()) {
                    $this->nameTaken = true;
                } else {
                    if ($this->registerModel->usernameOkLength($this->registerView->getNewUsername())) {
                        $this->nameOK = true;
                    }                
                }
            }

            if($this->registerView->pwdPost()) {
                //var_dump($this->registerView->getPwd());
                if ($this->registerModel->passwordOkLength($this->registerView->getPwd())) {
                    if ($this->registerView->pwdRepeatPost()) {
                        if ($this->registerView->getPwd() == $this->registerView->pwdRepeatPost()) {
                            $this->passwordOK = true;
                        }
                    }
                }
            }

            if ($this->nameOK && $this->passwordOK) {
                //add new user TODO
                $this->userCredentials->addUser($this->registerView->getNewUsername(), $this->registerView->getPwd());
            } else {
                $this->registerView->createMessage($this->nameTaken);
            }  
        }
        
    }

    public function checkIfUsernameTaken() : bool {
        $name = $this->registerView->getNewUsername();
        $nameTaken = $this->userCredentials->userExist($name);
        if($nameTaken) {
            return true;
        } else {
            return false;
        }
    }
    
}
