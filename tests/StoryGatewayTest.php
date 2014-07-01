<?php

require_once ('./resources/testconfig.php');

class StoryGatewayTest extends PHPUnit_Framework_TestCase {

    public function testGetOneById() {

        $m = Mockery::mock('Upvote\Model\Story\Storage');
        $m->shouldReceive('getStoryById')
          ->andReturn([
                'id' => 1,
                'headline' => 'test',
                'url' => 'http://www.google.com',
                'created_by' => 'Homer Simpson',
                'created_on' => date('c'),
                'comment_count' => 5,
            ]);

        $gateway = new Upvote\Model\Story\Gateway($m);
        $result = $gateway->getStoryById(1);

        $this->assertInstanceOf('Upvote\Model\Story\Story', $result);
    }

    public function testGetOneByIdNoDataIsNull() {
        $m = Mockery::mock('Upvote\Model\Story\Storage');
        $m->shouldReceive('getStoryById')
            ->andReturn(false);

        $gateway = new Upvote\Model\Story\Gateway($m);
        $result = $gateway->getStoryById(1);
        $this->assertNull($result);
    }

    public function testCollectionReturnedForGetAllStories() {
        $m = Mockery::mock('Upvote\Model\Story\Storage');
        $m->shouldReceive('getAllStories')
            ->andReturn([[
                'id' => 1,
                'headline' => 'test',
                'url' => 'http://www.google.com',
                'created_by' => 'Homer Simpson',
                'created_on' => date('c'),
                'comment_count' => 5,
            ],
                [
                    'id' => 2,
                    'headline' => 'test 2',
                    'url' => 'http://www.facebook.com',
                    'created_by' => 'Homer Simpson',
                    'created_on' => date('c'),
                    'comment_count' => 3,
                ]]);

        $gateway = new Upvote\Model\Story\Gateway($m);
        $result = $gateway->getAllStories();

        $this->assertEquals(2, $result->count());
    }

    public function testEmptyCollectionReturnedForGetAllStories() {
        $m = Mockery::mock('Upvote\Model\Story\Storage');
        $m->shouldReceive('getAllStories')
            ->andReturn([]);

        $gateway = new Upvote\Model\Story\Gateway($m);
        $result = $gateway->getAllStories();

        $this->assertEquals(0, $result->count());
    }

}