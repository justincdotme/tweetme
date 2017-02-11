# TweetMe
 A simple Twitter feed package for Laravel and Lumen 5.*. 
 TweetMe returns a collection of slimmed down Tweets from a user's Twitter message history.

## Requirements

    Laravel 5.*
    Lumen 5.*

### Lumen 5.* Installation
Install the package using Composer

    composer require justincdotme/tweetme

You can optionally enable Facades by uncommenting the following from bootstrap/app.php

    $app->withFacades();
    
Register the Service Provider by adding the following to bootstrap/app.php
    
    $app->register(Justincdotme\TweetMe\TweetServiceProvider::class);
    
    
## Laravel 5.* Installation

    composer require justincdotme/tweetme
    
    php artisan vendor:publish
    
###### Add the TweetServiceProvider to the providers array in app/config.php
    
    'providers' => [
        ...
        Justincdotme\TweetMe\TweetServiceProvider::class,
        ...
    ]

###### Add OAuth tokens and keys to .env
    OAUTH_CONSUMER_KEY=""
    OAUTH_ACCESS_TOKEN=""
    OAUTH_CONSUMER_SECRET=""
    OAUTH_ACCESS_TOKEN_SECRET=""
        
    
## Usage
    The TweetMe class exposes one method, getTweets(), which returns a collection.
    Feel free to use the Facade or inject the TweetMeInterface.
    Usage Examples: 
    
    $tweetArray = TweetMe::getTweets()->toArray();
    
    OR
    
    $jsonResponse = TweetMe::getTweets()->toJson();

## Todo
  - Implement the Guzzle HTTP lib
  - Replace OAuth with the Guzzle OAuth implementation