<?php

namespace View;

class LayoutView {

    public function render($isLoggedIn, LoginView $v, DateTimeView $dtv, RegisterView $regV, $goToRegister, NoteView $noteView) {
        echo '<!DOCTYPE html>
            <html>
                <head>
                <meta charset="utf-8">
                <title>Login Example</title>
                </head>
                <body>
                <h1>Assignment 2</h1>
                <div class="linkRegister">
                    ' . $this->presentLink($isLoggedIn, $goToRegister) . '
                </div>
                    ' . $this->renderIsLoggedIn($isLoggedIn) . '
                
                <div class="container">
                    ' . $this->rightResponse($isLoggedIn, $goToRegister, $v, $regV) . '

                    ' . $dtv->show() . '
                </div>

                <div class="notes">
                    ' . $this->notes($isLoggedIn, $noteView) . '
                </div>
                
                </body>
            </html>
        ';
    }

    private function notes($isLoggedIn, $noteView) {
        if ($isLoggedIn) {
            return $noteView->newNoteForm();
        }
        
    }

    public function userWantsToRegister() {
        //return $this->state->checkIfUserWantsToRegister();
    }

    private function presentLink($isLoggedIn, $goToRegister) {
        $link = '';
        
        if ($goToRegister) {
            $link = '<a href="?">Back to login</a>';
        } else if (!$isLoggedIn) {
            $link = '<a href="?register">Register a new user</a>';
        } else {
            $link = '';
        }
        
        return $link;
    }
    
    private function rightResponse($isLoggedIn, $newUserRegister, $v, $regV) {
        $response = '';
    
        if (!$newUserRegister) {
          $response = $v->response($isLoggedIn);
        } else {
          $message = '';
          $response = $regV->response($message);
        }
        
        return $response;
    }
    
    private function checkIfRegister($regV) {
        //$regV->render();
    }
      
    private function renderIsLoggedIn($isLoggedIn) {
        if ($isLoggedIn) {
            return '<h2>Logged in</h2>';
        }
        else {
            return '<h2>Not logged in</h2>';
        }
    }  
}