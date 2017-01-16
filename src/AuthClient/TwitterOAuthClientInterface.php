<?php

namespace Justincdotme\TweetMe\AuthClient;

/**
 * Interface TwitterOAuthClientInterface
 * @package Justincdotme\TweetMe\AuthClient
 */
interface TwitterOAuthClientInterface
{
    /**
     * Make request header for Twitter authentication.
     *
     * @return mixed
     */
    public function makeAuthHeader();
}