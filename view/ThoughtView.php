<?php

namespace View;

class ThoughtView {
    private static $noteTitle = 'ThoughtView::NoteTitle';
    private static $noteContext = 'ThoughtView::NoteContext';
    private static $notePublic = 'ThoughtView::NotePublic';
    private static $submitNewNote = 'ThoughtView::submitNewNote';

    public function renderPublicThoughtView() {
        return '
            <div>
                <p>alla  publika inlägg  </p>
            </div>

            <div>
                <p>Och fler</p>
            </div>
        
        ';
    }

    public function printOneThought() {
        return '
            <div>

            </div>

            <div>

            </div>
        
        ';
    }

    public function newThoughtForm() {
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
}