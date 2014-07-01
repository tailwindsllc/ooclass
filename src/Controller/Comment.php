<?php

namespace Upvote\Controller;

use Framework\Base;

class Comment extends Base\Controller {
    
    public function create() {
        if(!isset($_SESSION['AUTHENTICATED'])) {
            die('not auth');
            header("Location: /");
            exit;
        }
        
        $sql = 'INSERT INTO comment (created_by, created_on, story_id, comment) VALUES (:created_by, NOW(), :story_id, :comment)';
        $this->adapter->query($sql, array(
            'created_by' => $_SESSION['username'],
            'story_id' => $_POST['story_id'],
            'comment' => filter_input(INPUT_POST, 'comment', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
        ));
        header("Location: /story/?id=" . $_POST['story_id']);
    }
    
}