<?php

namespace Justincdotme\TweetMe;

use Justincdotme\TweetMe\Auth\OAuth;
use Illuminate\Config\Repository as Config;

class TweetMe implements TweetMeInterface
{
    protected $authenticator;
    protected $tweetParams;
    protected $tweets;


    public function __construct(OAuth $authenticator, Config $config)
    {
        $this->authenticator = $authenticator;
    }

    /**
     * Get the list of Tweets.
     *
     * Try to get Tweets from the cache file first.
     * Fetch Tweets from Twitter API if no cache/expired cache.
     *
     * TODO - Cache with Laravel
     *
     * @param array $params
     * @return \Illuminate\Support\Collection|string
     */
    public function getTweets( $params = [])
    {
        $this->tweetParams = $params;
        $cacheFile = 'cache/tweet-cache.txt'; //TODO - Get from config
        $expireTime = (15 * 60); //15 minutes.
        if ( file_exists( $cacheFile ) ) {
            if ( time() - $expireTime < filemtime( $cacheFile ) ) {
                $fileHandle = fopen( $cacheFile, 'r' );
                $file = fread( $fileHandle, filesize( $cacheFile ) );
                fclose( $fileHandle );
                //TODO - Set the return type here or figure out a better way to return
                return $file;
            } {
                unlink( $cacheFile );
            }
        }
        $tweets = $this->getRepackagedTweets();
        if ( !file_exists( 'cache' ) ) {
            mkdir( 'cache', 0775 );
        }
        $fh = fopen( $cacheFile, 'w' );
        fwrite( $fh, $tweets );
        fclose( $fh );
        return collect($tweets)->toJson();
    }

    /**
     * Eliminate unwanted tweet attributes.
     *
     */
    protected function getRepackagedTweets()
    {
        $this->tweets = [];
        foreach ( $this->fetchTweets($this->tweetParams) as $key => $tweet ) {
            $this->tweets[$key] = new Tweet();
            $this->tweets[$key]->setDate($tweet->created_at);
            $this->tweets[$key]->username($tweet->user->screen_name);
            $this->tweets[$key]->profileImage($tweet->user->profile_image_url_https);
            $this->tweets[$key]->setTweetText($tweet->text);
        }
    }

    /**
     * Fetch tweets from Twitter.
     *
     * @return array|bool
     */
    protected function fetchTweets()
    {
        $handle = curl_init();
        curl_setopt(
            $handle,
            CURLOPT_HTTPHEADER,
            $this->authenticator->makeAuthHeader()
            );
        curl_setopt( $handle, CURLOPT_HEADER, false );
        curl_setopt( $handle, CURLOPT_URL, $this->baseUrl );
        curl_setopt( $handle, CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $handle, CURLOPT_SSL_VERIFYPEER, false );

        $tweets = curl_exec( $handle );
        curl_close( $handle );

        return json_decode($tweets);
    }
}
