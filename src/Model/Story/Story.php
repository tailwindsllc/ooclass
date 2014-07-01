<?php

namespace Upvote\Model\Story;

class Story {

    public $id;
    public $headline;
    public $url;
    public $created_by;
    public $created_on;

    public $comment_count;

    protected $excluded = ['comment_count', 'excluded'];

    public function configure(array $values = array()) {
        foreach($values as $key => $value) {
            if(property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
        return $this;
    }

    public function getData() {
        $data = [];
        foreach($this as $k => $v) {
            if(!in_array($k, $this->excluded)) {
                $data[$k] = $v;
            }
        }

        if(empty($data['id'])) {
            unset($data['id']);
        }

        return $data;
    }

    public function getDateCreated() {
        return date('n/j/Y g:i a', strtotime($this->created_on));
    }
}