<?php

class TweetMeTest extends \PHPUnit_Framework_TestCase
{
    public function __construct($name = null, array $data = array(), $dataName = '')
    {
        //$this->oauthMock = $this->getMockBuilder('Justincdotme\TweetMe\AuthClient\AuthClientInterface')->getMock();

        $this->httpClientMock = $this->getMockBuilder('Justincdotme\TweetMe\HttpClient\HttpClientInterface')
            ->setMethods([])
            ->getMock();

        $this->oauthMock = $this->getMockBuilder('Justincdotme\TweetMe\AuthClient\AuthClientInterface')
            ->setMethods([])
            ->getMock();

        $this->configMock = $this->getMockBuilder('Illuminate\Contracts\Config\Repository')->getMock();

        $this->cacheMock = $this->getMockBuilder('Illuminate\Contracts\Cache\Repository')->getMock();

        $this->tweetMe = new Justincdotme\TweetMe\TweetMe(
            $this->oauthMock,
            $this->configMock,
            $this->cacheMock,
            $this->httpClientMock,
            new Carbon\Carbon
        );

        parent::__construct($name, $data, $dataName);
    }

    public function test_it_checks_cache_for_tweets ()
    {
        $this->cacheMock->expects($this->exactly(1))->method('get');
        $this->tweetMe->getTweets();
    }

    public function test_it_stores_tweets_in_cache ()
    {
        $this->cacheMock->expects($this->exactly(1))->method('put');
        $this->tweetMe->getTweets();
    }

    public function test_it_returns_a_collection ()
    {
        $this->assertInstanceOf(Illuminate\Support\Collection::class, $this->tweetMe->getTweets());
    }

    public function test_it_calls_make_auth_header ()
    {
        $this->oauthMock->expects($this->exactly(1))->method('makeAuthHeader');
        $this->tweetMe->getTweets();
    }
}