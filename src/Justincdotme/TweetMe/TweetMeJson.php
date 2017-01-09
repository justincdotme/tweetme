<?php

namespace Justincdotme\TweetMe;

class TweetMeJson implements TweetMeInterface
{

    protected $_tweetMe;

    public function __construct( TweetMe $tweetMe )
    {
        $this->_tweetMe = $tweetMe;
    }

    /**
     * Get a JSON formatted list of Tweets.
     *
     * @param $count
     * @return string
     */
    public function getTweets( $count )
    {
        return json_encode( $this->_tweetMe->getTweets( $count ) );
    }
}
