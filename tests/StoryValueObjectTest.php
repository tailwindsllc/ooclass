<?php

require_once ('./resources/testconfig.php');

class StoryValueObjectText extends PHPUnit_Framework_TestCase {

    public function testConfigurationOfObjectWorksCorrectly() {

        $values = array(
            'id' => 1,
            'headline' => 'test',
            'url' => 'http://www.google.com',
            'created_by' => 'Homer Simpson',
            'created_on' => date('c'),
            'comment_count' => 5,
        );

        $story = new Upvote\Model\Story\Story;
        $story->configure($values);

        $this->assertEquals($values['id'], $story->id);
        $this->assertEquals($values['headline'], $story->headline);
        $this->assertEquals($values['url'], $story->url);
        $this->assertEquals($values['created_by'], $story->created_by);
        $this->assertEquals($values['created_on'], $story->created_on);
        $this->assertEquals($values['comment_count'], $story->comment_count);
    }

    public function testGetDataGetsAllData() {
        $values = array(
            'id' => 1,
            'headline' => 'test',
            'url' => 'http://www.google.com',
            'created_by' => 'Homer Simpson',
            'created_on' => date('c'),
        );

        $story = new Upvote\Model\Story\Story;
        $story->configure($values);

        $data = $story->getData();

        $this->assertEquals($values, $data);
    }

    public function testGetDataDropsIdWhenNotSet() {
        $values = array(
            'headline' => 'test',
            'url' => 'http://www.google.com',
            'created_by' => 'Homer Simpson',
            'created_on' => date('c'),
        );

        $story = new Upvote\Model\Story\Story;
        $story->configure($values);

        $data = $story->getData();

        $this->assertEquals($values, $data);
    }

    public function testGetDateFormatsCorrectly() {
        $story = new Upvote\Model\Story\Story;
        $story->configure(['created_on' => 'June 3, 2014 01:02:03']);

        $date = $story->getDateCreated();
        $this->assertEquals('6/3/2014 1:02 am', $date);
    }

}