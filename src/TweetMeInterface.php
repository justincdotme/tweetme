<?php

namespace Justincdotme\TweetMe;

/**
 * Interface TweetMeInterface
 * @package Justincdotme\TweetMe
 */
interface TweetMeInterface
{

    /**
     * Get a collection of Tweets.
     *
     * @param $count
     * @return \Illuminate\Support\Collection
     */
    public function getTweets($count);

}
