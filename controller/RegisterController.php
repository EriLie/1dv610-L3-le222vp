<?php

namespace Controller;

class RegisterController {

    private $registerView;
    private $registerModel;


    public function __construct($registerView, $registerModel) {
        $this->registerView = $registerView;
        $this->registerModel = $registerModel;
    }

    public function checkIfAnyPost() {
        
    }
    
}
