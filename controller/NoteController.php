<?php

namespace Controller;

require_once('model/Database.php');
require_once('model/NoteModel.php');

class NoteController {
    public function __construct() {
        $this->database = new \Model\Database();
        $this->state = new \Model\StateModel();
    } 

    public function run($noteView) {
        if ($noteView->addNewNotePost()) {
            $this->saveAddedNote($noteView);
        }

        if ($noteView->deleteNotePost()) {
            $this->deleteOneNote($noteView);
        }
    }

    private function saveAddedNote($noteView) {
        // TODO should validate that all inputs has value/right type/not bad

        $id = null; // Only NoteModel need id, the database has auto increment
        $author = $this->state->getLoggedInUsername();
        $title = $noteView->getNoteTitle();
        $content = $noteView->getNoteContent();
        $public = $noteView->isPublicPost();
        $created = date("Y-m-d H:i:s");
        
        $newNote = new \Model\NoteModel($id, $author, $title, $content, $public, $created);
        $this->database->saveNote($newNote);     
    }

    private function deleteOneNote($noteView) {
        $noteIdToDelete = $noteView->getNoteIdToDelete();
        $this->database->deleteNote($noteIdToDelete);
    }
}