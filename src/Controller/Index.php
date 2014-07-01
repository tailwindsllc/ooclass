<?php

namespace Upvote\Controller;

use Framework\Base;
use Upvote\Model\Story;

class Index {

    protected $gateway;

    public function __construct(Story\Gateway $gateway) {
        $this->gateway = $gateway;
    }

    public function index() {

        $stories = $this->gateway->getAllStories();
        
        $content = '<ol>';
        
        foreach($stories as $story) {

            $content .= '
                <li>
                <a class="headline" href="' . $story->url . '">' . $story->headline . '</a><br />
                <span class="details">' . $story->created_by . ' | <a href="/story/?id=' . $story->id . '">' . $story->comment_count . ' Comments</a> |
                ' . $story->getDateCreated() . '</span>
                </li>
            ';
        }
        
        $content .= '</ol>';
        
        require '../layout.phtml';
    }
}

