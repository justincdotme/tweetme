<?php namespace tweetMe\lib;

/**
 * Class TweetMe
 *
 * The TweetMe class fetches Tweets from a user's timeline.
 *
 * The class requires 2 parameters, $credentials and $tweetCount.
 * $credentials should be an array containing your Twitter API keys.
 * $tweetCount should be an integer specifying the number of Tweets to return.
 * This class is enhanced via two decorator classes, TweetMeHtml and TweetMeJson.
 * TweetMe will return the statuses from a user's Twitter Timeline using the Twitter REST API 1.1.
 * Use of this application requires a Twitter API key which can be obtained at https://apps.twitter.com
 * This application caches JSON responses (/cache/tweet-cache.txt) for 15 minutes to avoid Twitter's rate limiting.

 *
 * The $credentials array should be structured as follows:
 * $credentials = [
 * 'oauth_access_token' => ' OAuth token goes here',
 * 'oauth_access_token_secret' => 'OAuth token secret here',
 * 'consumer_key' => 'consumer key here',
 * 'consumer_secret' => 'consumer secret here'
 * ];
 *
 *
 * PHP Version 5.6
 *
 * License: Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package TweetMe
 * @author Justin Christenson <info@justinc.me>
 * @version 1.0.0
 * @license http://opensource.org/licenses/mit-license.php
 * @link http://findmyisp.demos.justinc.me
 *
 */

class TweetMe implements TweetMeInterface {

    protected $_credentials;
    protected $_oauth;
    protected $_baseInfo;
    protected $_baseUrl;
    protected $_compositeKey;
    protected $_oauthSignature;

    public function __construct(array $credentials)
    {
        $this->_credentials = $credentials;
        $this->_oauth = [
            'oauth_consumer_key' => $this->_credentials['consumer_key'],
            'oauth_nonce' => time(),
            'oauth_signature_method' => 'HMAC-SHA1',
            'oauth_timestamp' => time(),
            'oauth_token' => $this->_credentials['oauth_access_token'],
            'oauth_version' => '1.0'
        ];
        $this->_baseUrl = 'https://api.twitter.com/1.1/statuses/user_timeline.json';
        $this->_baseInfo = $this->makeBaseString($this->_baseUrl, $this->_oauth);
        $this->_compositeKey = $this->makeCompositeKey($this->_credentials);
        $this->_oauthSignature = $this->makeOauthSignature($this->_baseInfo, $this->_compositeKey);
        $this->_oauth['oauth_signature'] = $this->_oauthSignature;
    }

    /**
     * Create base string for oAuth request.
     * [https://dev.twitter.com/oauth/overview/authorizing-requests]
     *
     * @return string
     */
    protected function makeBaseString()
    {
        $parametersContainer = [];
        //Twitter requires parameters to be sorted alphabetically by key.
        ksort($this->_oauth);
        foreach($this->_oauth as $key=>$value){
            //Returns strings as "key=value"
            array_push($parametersContainer, "$key=" . rawurlencode($value));
        }
        return "GET&" . rawurlencode($this->_baseUrl) . '&' . rawurlencode(implode('&', $parametersContainer));
    }

    /**
     * Generate the oAuth header.
     * [https://dev.twitter.com/oauth/overview/authorizing-requests]
     *
     * @return string
     */
    protected function makeAuthHeader()
    {
        $header = 'Authorization: OAuth ';
        $values = [];
        foreach($this->_oauth as $key=>$value)
            array_push($values, "$key=\"" . rawurlencode($value) . "\"");
        $header .= implode(', ', $values);
        return $header;
    }

    /**
     * Create the composite key.
     * Combines consumer_secret and oauth_access_token_secret.
     *
     * @return string
     */
    protected function makeCompositeKey()
    {
        $compositeKey = rawurlencode($this->_credentials['consumer_secret']);
        $compositeKey .= '&' . rawurlencode($this->_credentials['oauth_access_token_secret']);
        return $compositeKey;
    }

    /**
     * Sign the composite key+base info.
     * Return Open Auth signature for use in cURL request.
     *
     * @param $base_info
     * @param $composite_key
     * @return string
     */
    protected function makeOauthSignature($base_info, $composite_key)
    {
        return base64_encode(hash_hmac('sha1', $base_info, $composite_key, true));
    }

    /**
     * cURL the Twitter API.
     * Get the latest user timeline.
     *
     * @return mixed
     */
    protected function getRawTwitter()
    {
        $header = [
            $this->makeAuthHeader($this->_oauth), 'Expect:'
        ];
        $feed = curl_init();
        curl_setopt($feed, CURLOPT_HTTPHEADER, $header);
        curl_setopt($feed, CURLOPT_HEADER, false);
        curl_setopt($feed, CURLOPT_URL, $this->_baseUrl);
        curl_setopt($feed, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($feed, CURLOPT_SSL_VERIFYPEER, false);

        $json = curl_exec($feed);
        curl_close($feed);
        return $json;
    }

    /**
     * Re-package the JSON response from Twitter API.
     * We only need date, user, profile image and tweet text.
     * Convert URLs and Hashtags into clickable links via Regex.
     *
     * @param $count
     * @return string
     */
    protected function makeRepackagedTweets($count)
    {
        $tweets = json_decode($this->getRawTwitter());
        $repackagedTweets = [];
        $i = 0;
        foreach($tweets as $key => $tweet)
        {
            //Replace URLs with links.
            $text = preg_replace('!(http|https)(s)?:\/\/[a-zA-Z0-9.?&_/]+!', "<a target=\"_BLANK\" href=\"\\0\">\\0</a>",$tweet->text);
            //Replace #hashtags with links.
            $text = preg_replace('/(^|\s)#(\w*[a-zA-Z_]+\w*)/', '<a target="_BLANK" href="https://twitter.com/hashtag/\\2?src=hash">\\0</a>' , $text);

            $repackagedTweets[$key] = [
                'date'               => $this->getFormattedTweetDate($tweet->created_at),
                'user_name'          => $tweet->user->screen_name,
                'user_profile_image' => $tweet->user->profile_image_url_https,
                'tweet'              => $text
            ];

            if(++$i == $count)
            {
                break;
            }
        }
        return json_encode($repackagedTweets);
    }

    /**
     * Format the Tweet date.
     * Old format Wed Aug 29 17:12:58 +0000 2012.
     * New format Wed, Aug 29, 2012
     *
     * @param $date
     * @return string
     */
    protected function getFormattedTweetDate($date)
    {
        $tweetDate = explode(' ', $date);
        $formattedDate = $tweetDate[0] . ', ' . $tweetDate[1] . ' ' . $tweetDate[2] . ', ' . $tweetDate[5];
        return $formattedDate;
    }

    /**
     * Get the list of Tweets.
     *
     * Try to get Tweets from the cache file first.
     * Fetch Tweets from Twitter API if no cache/expired cache.
     *
     * @param $count
     * @return string
     */
    public function getTweets($count)
    {
        $cacheFile = 'cache/tweet-cache.txt';
        $expireTime = 15 * 60; //15 minutes.
        if(file_exists($cacheFile))
        {
            $fh = fopen($cacheFile, 'r');

            if(time() - $expireTime < filemtime($cacheFile))
            {
                return fread($fh, filesize($cacheFile));
            }
            fclose($fh);
            unlink($cacheFile);
        }
        $tweets = $this->makeRepackagedTweets($count);
        if(!file_exists('cache'))
        {
            mkdir('cache', 0775);
        }
        $fh = fopen($cacheFile, 'w');
        fwrite($fh, $tweets);
        fclose($fh);
        return $tweets;
    }
}
