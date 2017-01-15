<?php

namespace Justincdotme\TweetMe\HttpClient;

interface HttpClientInterface
{
    public function getTweets(array $params);
}