<?php

namespace Justincdotme\TweetMe\AuthClient;

interface AuthClientInterface
{
    public function makeAuthHeader();
}