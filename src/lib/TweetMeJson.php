<?php namespace tweetMe\lib;

/**
 * Class TweetMeJson
 *
 * The TweetMeJson class decorates the TweetMe class by adding JSON output functionality.
 *
 * This class has 1 dependency, an instance of TweetMe.
 * TweetMeJson contains one method, getTweets(), which outputs Tweets in JSON format.
 * Twitter Bootstrap v3 is required for proper formatting of output. http://getbootstrap.com
 *
 * Use
 * require '../src/autoload.php';
 * header('Content-Type: application/json');
 * $tweetMe = new TweetMe($credentials);
 * $tweetsJson = new TweetMeJson($tweetMe);
 * echo json_decode($tweetsJson->getTweets(12); //Where 12 is the number of Tweets to return.
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
 * @link https://tweetme.demos.justinc.me
 *
 */

class TweetMeJson implements TweetMeInterface {

    protected $_tweetMe;

    public function __construct(TweetMe $tweetMe)
    {
        $this->_tweetMe = $tweetMe;
    }

    /**
     * Get a JSON formatted list of Tweets.
     *
     * @param $count
     * @return string
     */
    public function getTweets($count)
    {
        return json_encode($this->_tweetMe->getTweets($count));
    }
}
