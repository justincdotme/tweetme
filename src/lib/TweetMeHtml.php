<?php namespace tweetMe\lib;

/**
 * Class TweetMeHtml
 *
 * The TweetMeHtml class decorates the TweetMe class by adding HTML output functionality.
 *
 * This class has 1 dependency, an instance of TweetMe.
 * This class contains one method, getTweets(), which outputs HTML formatted Tweets.
 * Twitter Bootstrap v3 is required for proper formatting of output. http://getbootstrap.com
 *
 * Use
 * require '../src/autoload.php';
 * $tweetMe = new TweetMe($credentials);
 * $htmlTweets = new TweetMeHtml($tweetMe);
 * echo $htmlTweets->getTweets(12); //Where 12 is the number of Tweets to return.
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

class TweetMeHtml implements tweetMeInterface {

    protected $_tweetMe;

    public function __construct(TweetMe $tweetMe)
    {
        $this->_tweetMe = $tweetMe;
    }

    /**
     * Get an HTML formatted list of Tweets.
     *
     * @param $count
     * @return array
     */
    public function getTweets($count)
    {
        $tweets = json_decode($this->_tweetMe->getTweets($count));
        //$formattedTweets = [];
        $html = '<ul class="list-group">' . "\r\n";
        foreach($tweets as $key => $tweet)
        {
            //Begin Tweet li
            $html .= '<li class="list-group-item tweet">' . "\r\n";
            //Begin date row
            $html .= '<div class="row">' . "\r\n";
            $html .= '<div class="col-sm-12">' . "\r\n";
            $html .= '<span class="pull-right badge tweet-date">' . $tweet->date . '</span>' . "\r\n";
            $html .= '</div>' . "\r\n";
            $html .= '</div>' . "\r\n";
            //End date row
            //Begin Tweet row
            $html .= '<div class="row">' . "\r\n";
            //Begin image link
            $html .= '<div class="col-sm-2 col-md-1">' . "\r\n";
            $html .= '<a href="https://www.twitter.com/' . $tweet->user_name . '" target="_BLANK">' . "\r\n";
            $html .= '<img class="inline thumb" src="' . $tweet->user_profile_image . '">' . "\r\n";
            $html .= '</a>' . "\r\n";
            $html .= '</div>' . "\r\n";
            //End image link
            //Begin Tweet col
            $html .= '<div class="col-sm-10 col-md-11">' . "\r\n";
            $html .= '<div class="tweet-container">' . "\r\n";
            $html .= '<p class="">' . $tweet->tweet . '</p>' . "\r\n";
            $html .= '</div>' . "\r\n";
            $html .= '</div>' . "\r\n";
            //End Tweet col
            $html .= '</div>' . "\r\n";
            //End Tweet row
            $html .= '</li>' . "\r\n";
            //End Tweet li
        }
        $html .= '</ul>';
        return $html;
    }
}
