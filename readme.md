# TweetMe
 A simple Twitter feed package for Laravel 5. 
 TweetMe returns a collection of slimmed down Tweets from a user's Twitter message history.

## Requirements

    Laravel 5.x

## Installation

    composer require justincdotme/tweetme 1.0.0
    
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
      
## License

 The MIT License (MIT)
 
 Copyright (c) 2015 Justin Christenson
 
 Permission is hereby granted, free of charge, to any person obtaining a copy
 of this software and associated documentation files (the "Software"), to deal
 in the Software without restriction, including without limitation the rights
 to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 copies of the Software, and to permit persons to whom the Software is
 furnished to do so, subject to the following conditions:
 
 The above copyright notice and this permission notice shall be included in
 all copies or substantial portions of the Software.
 
 THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 THE SOFTWARE.
