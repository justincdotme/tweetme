<?php
/**
 * Configuration options for the TweetMe package.
 */
return [
    'oauth_consumer_key' => env('OAUTH_CONSUMER_KEY'),
    'oauth_access_token' => env('OAUTH_ACCESS_TOKEN'),
    'oauth_consumer_secret' => env('OAUTH_CONSUMER_SECRET'),
    'oauth_access_token_secret' => env('OAUTH_ACCESS_TOKEN_SECRET'),
    'oauth_nonce' => time(),
    'oauth_signature_method' => 'HMAC-SHA1',
    'oauth_base_url' => 'https://api.twitter.com/1.1/statuses/user_timeline.json'
];