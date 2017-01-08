# TweetMe
 An application for retrieving the statuses from a Twitter user's timeline using the Twitter REST API 1.1. This application caches JSON responses in public/cache/tweet-cache.txt for 15 minutes to avoid Twitter's rate limiting.

**View Demo**
 [https://tweetme.demos.justinc.me](https://tweetme.demos.justinc.me)
 
## Requirements
 
 - Use of this application requires a Twitter API key which can be obtained from [https://apps.twitter.com](https://apps.twitter.com)
 - Bootstrap v3 is required for proper formatting of output. [getbootstrap.com](http://getbootstrap.com)

## Installation

 Clone the repository
 
    git clone https://github.com/justincdotme/tweetme.git
      

## Usage

 The class constructor requires 1 parameter: $credentials. 
 
 - $credentials should be an array containing your Twitter API keys.

 The $credentials array should be structured as follows:

    $credentials = [
        'oauth_access_token' => ' OAuth token here',
        'oauth_access_token_secret' => 'OAuth token secret here',
        'consumer_key' => 'consumer key here',
        'consumer_secret' => 'consumer secret here'
    ];

 **HTML option**
 
 See public/tweetme-html.php for example HTML implementation.

    require '../src/autoload.php';
    $tweetMe = new TweetMe($credentials); 
    $htmlTweets = new TweetMeHtml($tweetMe);
    echo $htmlTweets->getTweets(12); //Where 12 is the number of Tweets to return.
    
 **JSON option**

 See public/tweetme-json.php for example JSON implementation.

    require '../src/autoload.php';
    header('Content-Type: application/json');
    $tweetMe = new TweetMe($credentials); 
    $tweetsJson = new TweetMeJson($tweetMe);
    echo json_decode($tweetsJson->getTweets(12)); //Where 12 is the number of Tweets to return.

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
