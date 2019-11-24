<?php

namespace View;

class ThoughtView {

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
            <div id="">

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
                    <input type="text" size="20" name="titleNote" id="" value="" />
                    <br>

                    <p>Thoughts of the day:  </p>
                    <textarea name="contextThought" cols="40" rows="10" id="" value="" ></textarea>
                    <br>

                    <p>Make it public:  </p>                    
                    <input type="checkbox" name="showNoteInPublic" id="" value="makePublic" />

                    <br>
                    <br>
                    <input id="submit" type="submit" name="saveNote"  value="Save" />
                    <br>
                </fieldset>
            </form> 
        ';
    }
}