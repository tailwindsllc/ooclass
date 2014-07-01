<?php

namespace Upvote\Model\Story;

class Gateway {

    protected $storage;

    public function __construct(Storage $storage) {
        $this->storage = $storage;
    }

    public function getStoryById($id) {
        $data = $this->storage->getStoryById($id);
        if(!$data) {
            return;
        }

        $story = new Story();
        $story->configure($data);
        return $story;
    }

    public function getAllStories() {
        $collection = new StoryCollection();

        $data = $this->storage->getAllStories();
        foreach($data as $story_data) {
            $story = new Story();
            $story->configure($story_data);
            $collection->addEntry($story);
        }

        return $collection;
    }

}