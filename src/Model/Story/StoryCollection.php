<?php

namespace Upvote\Model\Story;

class StoryCollection implements \Iterator, \Countable {

    protected $collection = array();

    public function addEntry(Story $story) {
        $this->collection[] = $story;
        return $this;
    }

    public function addEntries(array $stories = array()) {
        foreach($stories as $story) {
            $this->addEntry($story);
        }
        return $this;
    }

    public function count() {
        return count($this->collection);
    }

    public function current() {
        return current($this->collection);
    }

    public function key() {
        return key($this->collection);
    }

    public function next() {
        return next($this->collection);
    }

    public function rewind() {
        reset($this->collection);
    }

    public function valid() {
        return (bool) $this->current();
    }

}