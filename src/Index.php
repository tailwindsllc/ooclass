<?php

namespace Upvote;

use Framework\Base;

class Index extends Base\Controller {

    public function index() {
        
        $sql = 'SELECT * FROM story ORDER BY created_on DESC';
        $stories = $this->adapter->fetchAll($sql);
        
        $content = '<ol>';
        
        foreach($stories as $story) {
            $comment_sql = 'SELECT COUNT(*) as `count` FROM comment WHERE story_id = :id';
            $count = $this->adapter->fetchOne($comment_sql, ['id' => $story['id']]);
            $content .= '
                <li>
                <a class="headline" href="' . $story['url'] . '">' . $story['headline'] . '</a><br />
                <span class="details">' . $story['created_by'] . ' | <a href="/story/?id=' . $story['id'] . '">' . $count['count'] . ' Comments</a> | 
                ' . date('n/j/Y g:i a', strtotime($story['created_on'])) . '</span>
                </li>
            ';
        }
        
        $content .= '</ol>';
        
        require '../layout.phtml';
    }
}

