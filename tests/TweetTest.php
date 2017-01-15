<?php

class TweetTest extends \PHPUnit_Framework_TestCase
{
    protected $tweet;

    public function __construct($name = null, array $data = array(), $dataName = '')
    {
        $this->tweet = new \Justincdotme\TweetMe\Tweet([
            'tweetContent' => 'Lorem ipsum dolor test amet @justincdotme http://www.justinc.me #testing',
            'profileImage' => '',
            'username' => '',
            'dateTweeted' => 'Wed Aug 29 17:12:58 +0000 2012',
        ]);
        parent::__construct($name, $data, $dataName);
    }

    public function test_it_formats_tweet_content()
    {
        $expectedResult = 'Lorem ipsum dolor test amet <a href="https://www.twitter.com/justincdotme">@justincdotme</a> '.
            '<a target="_BLANK" href="http://www.justinc.me">http://www.justinc.me</a>'.
            '<a target="_BLANK" href="https://twitter.com/hashtag/testing?src=hash"> #testing</a>';
        $this->assertEquals($this->tweet->tweetContent, $expectedResult);
    }

    public function test_it_formats_date_tweeted()
    {
        $expectedResult = 'Wed, Aug 29, 2012';
        $this->assertEquals($this->tweet->dateTweeted, $expectedResult);
    }
}