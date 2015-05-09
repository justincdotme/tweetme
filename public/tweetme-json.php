<?php

/**
 * TweetMe JSON output example.
 */

use tweetMe\lib\TweetMe;
use tweetMe\lib\TweetMeJson;

//Define Twitter API credentials here.
$credentials = [
    'oauth_access_token' => ' OAuth token goes here',
    'oauth_access_token_secret' => 'OAuth token secret here',
    'consumer_key' => 'consumer key here',
    'consumer_secret' => 'consumer secret here'
];

require '../src/autoload.php';
header('Content-Type: application/json');
$tweetMe = new TweetMe($credentials, 12);
$tweetsJson = new TweetMeJson($tweetMe);
echo json_decode($tweetsJson->getTweets());
