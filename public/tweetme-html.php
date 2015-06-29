<?php

/**
 * TweetMe HTML output example.
 */

use tweetMe\lib\TweetMe;
use tweetMe\lib\TweetMeHtml;

//Set Twitter API keys.
$credentials = [
    'oauth_access_token' => ' OAuth token goes here',
    'oauth_access_token_secret' => 'OAuth token secret here',
    'consumer_key' => 'consumer key here',
    'consumer_secret' => 'consumer secret here'
];

//HTML option
require '../src/autoload.php';
$tweetMe = new TweetMe($credentials);
$htmlTweets = new TweetMeHtml($tweetMe);
echo $htmlTweets->getTweets(12);
