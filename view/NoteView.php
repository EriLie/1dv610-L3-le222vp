<?php

namespace View;

class NoteView {


    public function newNoteForm() {
        return '
            <h2>Add a note:</h2>
            <form method="post" id="addNote">
                <fieldset>
                
                    <input type="text" size="20" name="" id="" value="" />
                    <input id="submit" type="submit" name=""  value="Send" />
                    <br>
                </fieldset>
            </form> 
        ';
    }
}