<?php

namespace Upvote\Model\Story;

use Aura\Sql\Connection\AbstractConnection;

class Storage {

    protected $connection;

    public function __construct(AbstractConnection $connection) {
        $this->connection = $connection;
    }

    public function getStoryById($id) {
        $id = (int)$id;
        $select = '
        SELECT story.*, COUNT(comment.id) as comment_count
        FROM story
        LEFT JOIN comment ON comment.story_id = story.id
        WHERE story.id = :id
        ';

        return $this->connection->fetchOne($select, ['id' => $id]);
    }

    public function getAllStories() {
        $select = '
        SELECT story.*, COUNT(comment.id) as comment_count
        FROM story
        LEFT JOIN comment ON comment.story_id = story.id
        GROUP BY story.id
        ORDER BY created_on DESC
        ';

        return $this->connection->fetchAll($select);
    }

}