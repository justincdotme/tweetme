# TweetMe
 A simple Twitter feed package for Laravel 5. 
 TweetMe returns a collection of slimmed down Tweets from a user's Twitter message history.

## Requirements

    Laravel 5.x

## Installation

    composer require justincdotme/tweetme
    
    php artisan vendor:publish
    
###### Add the TweetServiceProvider to the providers array in app/config.php
    
    'providers' => [
        ...
        Justincdotme\TweetMe\TweetServiceProvider::class,
        ...
    ]
    
###### Add the Facade to the aliases array in config/app.php
    
    'aliases' => [
        ...
        'TweetMe' => Justincdotme\TweetMe\TweetMeFacade::class,
        ...
    ]

###### Add OAuth tokens and keys to .env
    An example file, .env.tweetme, will be published to the app root directory. 
    Copy the entries and use them as a starting point for configuring your OAuth credentials.
        
    
## Usage
    The package exposes one method via the TweetMe class.
    Feel free to use the Facade or inject the TweetMeInterface.
    Usage Examples: 
    
    $tweetArray = TweetMe::getTweets()->toArray();
    
    OR
    
    $jsonResponse = TweetMe::getTweets()->toJson();
