<?php

namespace View;

require_once('model/Database.php');


class NoteView {



    private static $noteTitle = 'NoteView::NoteTitle';
    private static $noteContext = 'NoteView::NoteContext';
    private static $notePublic = 'NoteView::NotePublic';
    private static $submitNewNote = 'NoteView::submitNewNote';

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
        return $this->addNewNoteForm() . $this->printLoggedInUserNotes();
    }

    public function addNewNoteForm() {
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

    public function printLoggedInUserNotes() {
        // TODO Not a good solution but it works... View - readonly - Model
        $database = new \Model\Database();
        return $database->getNotesFromLoggedInUser();
        
        //
        
        /* 
        '
            <br>

        
        ';*/
    }

    public function printOneNote() {
        return '
            <div>

                <div>

                </div>
            </div>        
        ';
    }

}