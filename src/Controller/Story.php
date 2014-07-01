<?php

namespace Upvote\Controller;

use Framework\Base;

class Story extends Base\Controller {

    public function index() {
        if(!isset($_GET['id'])) {
            header("Location: /");
            exit;
        }
        
        $story_sql = 'SELECT * FROM story WHERE id = :id';
        $story = $this->adapter->fetchOne($story_sql, ['id' => $_GET['id']]);
        if(count($story) < 1) {
            header("Location: /");
            exit;
        }

        $comment_sql = 'SELECT * FROM comment WHERE story_id = :id';

        $comments = $this->adapter->fetchAll($comment_sql, ['id' => $story['id']]);
        $comment_count = count($comments);

        $content = '
            <a class="headline" href="' . $story['url'] . '">' . $story['headline'] . '</a><br />
            <span class="details">' . $story['created_by'] . ' | ' . $comment_count . ' Comments | 
            ' . date('n/j/Y g:i a', strtotime($story['created_on'])) . '</span>
        ';
        
        if(isset($_SESSION['AUTHENTICATED'])) {
            $content .= '
            <form method="post" action="/comment/create">
            <input type="hidden" name="story_id" value="' . $_GET['id'] . '" />
            <textarea cols="60" rows="6" name="comment"></textarea><br />
            <input type="submit" name="submit" value="Submit Comment" />
            </form>            
            ';
        }
        
        foreach($comments as $comment) {
            $content .= '
                <div class="comment"><span class="comment_details">' . $comment['created_by'] . ' | ' .
                date('n/j/Y g:i a', strtotime($story['created_on'])) . '</span>
                ' . $comment['comment'] . '</div>
            ';
        }
        
        require_once '../layout.phtml';
        
    }
    
    public function create() {
        if(!isset($_SESSION['AUTHENTICATED'])) {
            header("Location: /user/login");
            exit;
        }
        
        $error = '';
        if(isset($_POST['create'])) {
            if(!isset($_POST['headline']) || !isset($_POST['url']) ||
               !filter_input(INPUT_POST, 'url', FILTER_VALIDATE_URL)) {
                $error = 'You did not fill in all the fields or the URL did not validate.';       
            } else {
                $sql = 'INSERT INTO story (headline, url, created_by, created_on) VALUES (:headline, :url, :created_by, NOW())';
                $this->adapter->query($sql, array(
                   'headline' => $_POST['headline'],
                   'url' => $_POST['url'],
                   'created_by' => $_SESSION['username'],
                ));
                
                $id = $this->adapter->getPdo()->lastInsertId();
                header("Location: /story/?id=$id");
                exit;
            }
        }
        
        $content = '
            <form method="post">
                ' . $error . '<br />
        
                <label>Headline:</label> <input type="text" name="headline" value="" /> <br />
                <label>URL:</label> <input type="text" name="url" value="" /><br />
                <input type="submit" name="create" value="Create" />
            </form>
        ';
        
        require_once '../layout.phtml';
    }
    
}