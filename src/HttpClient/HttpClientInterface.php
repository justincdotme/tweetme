<?php

namespace Justincdotme\TweetMe\HttpClient;

/**
 * Interface HttpClientInterface
 * @package Justincdotme\TweetMe\HttpClient
 */
interface HttpClientInterface
{
    /**
     * Fetch Tweets from remote source.
     *
     * @param array $params
     * @return mixed
     */
    public function getTweets(array $params);
}