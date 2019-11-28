<?php

namespace View;

require_once('model/Database.php');


class NoteView {



    private static $noteTitle = 'NoteView::NoteTitle';
    private static $noteContext = 'NoteView::NoteContext';
    private static $notePublic = 'NoteView::NotePublic';
    private static $submitNewNote = 'NoteView::submitNewNote';
    private static $deleteNote = 'NoteView::DeleteNote';

    public function renderPublicNoteView() {
        return '
            <div>
                <p>alla  publika inlägg  </p>
            </div>

            <div>
                <p>Och fler</p>
            </div>
        
        ';
    }

    
    public function renderWhenLoggedIn() {
        return "<div>" . $this->addNewNoteForm() . $this->printLoggedInUserNotes() . "</div>";
    }

    private function addNewNoteForm() {
        return '
            <h2>Add a thought:</h2>
            <form method="post" id="addNote">
                <fieldset>
                    <p>Title:  </p>
                    <input type="text" size="20" name="' . self::$noteTitle . '" id="' . self::$noteTitle . '" value="" />
                    <br>

                    <p>Thoughts of the day:  </p>
                    <textarea name="' . self::$noteContext . '" cols="40" rows="10" id="' . self::$noteContext . '" value="" ></textarea>
                    <br>

                    <p>Make it public:  </p>                    
                    <input type="checkbox" name="' . self::$notePublic . '" id="' . self::$notePublic . '" value="makePublic" />

                    <br>
                    <br>
                    <input id="' . self::$submitNewNote . '" type="submit" name="' . self::$submitNewNote . '"  value="Save" />
                    <br>
                </fieldset>
            </form> 
        ';
    }

    private function printLoggedInUserNotes() {
        // TODO Not a good solution but it works... View - readonly - Model
        $database = new \Model\Database();
        $oneUsersNotes = $database->getNotesFromLoggedInUser();
        $notesInHTML = '';

        foreach ($oneUsersNotes as $oneNote) {
            $htmlNote = "<br><fieldset>" . $this->printOneNote($oneNote) . $this->addDeleteButtonToOneNote($oneNote->getId()) . "</fieldset>";
            $notesInHTML .= $htmlNote;
        }

        return '<div class="allNotesOnPage">' . $notesInHTML . '</div>';
    }

    private function printOneNote($oneNote) {
        return '
            <div>
                <h4>' . $oneNote->getTitle()  . ', ' . $this->publicOrNot($oneNote->getPublic()) . '</h4>
                <h6>Created: ' . $oneNote->getCreated()  . ' by ' . $oneNote->getAuthor()  . '</h6>
                <p>' . $oneNote->getContent() . '</p>
            </div>        
        ';
    }

    private function publicOrNot($public) : string {
        return $public ? "(Public)" : "(Not Public)";
    }

    private function addDeleteButtonToOneNote($id) : string {
        return '
            <form method="post">
                <input type="hidden" name="noteId" value="' . $id . '">
                <input type="submit" name="' . self::$deleteNote . '" value="Delete" />
            </form>
        ';
    }

}