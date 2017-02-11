<?php

use \PHPUnit\Framework\TestCase;

class TweetMeTest extends TestCase
{
    public function __construct($name = null, array $data = array(), $dataName = '')
    {
        $this->httpClientMock = $this->getMockBuilder(Justincdotme\TweetMe\HttpClient\HttpClientInterface::class)
            ->setMethods([])
            ->getMock();

        $this->oauthMock = $this->getMockBuilder(Justincdotme\TweetMe\AuthClient\TwitterOAuthClientInterface::class)
            ->setMethods([])
            ->getMock();

        $this->configMock = $this->getMockBuilder(Illuminate\Contracts\Config\Repository::class)->getMock();

        $this->cacheMock = $this->getMockBuilder(Illuminate\Contracts\Cache\Repository::class)->getMock();

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

    public function test_it_calls_get_tweets_on_http_client ()
    {
        $this->httpClientMock->expects($this->exactly(1))->method('getTweets');
        $this->tweetMe->getTweets();
    }
}