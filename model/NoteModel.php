<?php

namespace Model;

class NoteModel {
    private $id;
    private $author;
    private $title;
    private $content;
    private $public;
    private $created;

    public function __construct($id, $author, $title, $content, $public, $created) {
        $this->id = $id;
        $this->author = $author;
        $this->title = $title;
        $this->content = $content;
        $this->public = $public;
        $this->created = $created;
    }

    // Vi behöver getters?
    public function getId() { return $this->id; }
    public function getAuthor() { return $this->author; }
    public function getTitle() { return $this->title; }
    public function getContent() { return $this->content; }
    public function getPublic() { return $this->public; }
    public function getCreated() { return $this->created; }
}





  