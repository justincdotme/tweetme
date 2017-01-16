<?php

namespace Justincdotme\TweetMe;

use Carbon\Carbon;
use Justincdotme\TweetMe\AuthClient\TwitterOAuthClientInterface as OAuth;
use Justincdotme\TweetMe\HttpClient\HttpClientInterface as HttpClient;
use Illuminate\Contracts\Config\Repository as Config;
use Illuminate\Contracts\Cache\Repository as Cache;

/**
 * Class TweetMe
 * Factory for generating Tweet collection.
 *
 * @package Justincdotme\TweetMe
 */
class TweetMe implements TweetMeInterface
{
    /**
     * @var OAuth
     */
    protected $authenticator;
    /**
     * @var
     */
    protected $tweetParams;
    /**
     * @var Config
     */
    protected $config;
    /**
     * @var Cache
     */
    protected $cache;
    /**
     * @var HttpClient
     */
    protected $httpClient;
    /**
     * @var
     */
    protected $collection;
    /**
     * @var Carbon
     */
    protected $date;


    /**
     * TweetMe constructor.
     * @param OAuth $authenticator
     * @param Config $config
     * @param Cache $cache
     * @param HttpClient $httpClient
     * @param Carbon $date
     */
    public function __construct(
        OAuth $authenticator,
        Config $config,
        Cache $cache,
        HttpClient $httpClient,
        Carbon $date
    )
    {
        $this->authenticator = $authenticator;
        $this->config = $config;
        $this->cache = $cache;
        $this->httpClient = $httpClient;
        $this->date = $date;
    }

    /**
     * Get a collection of repackaged Tweets.
     * Try to get Tweets from the cache store first.
     * Fetch Tweets from Twitter API if no/expired cache.
     *
     *
     * @param array $params
     * @return \Illuminate\Support\Collection
     */
    public function getTweets($params = [])
    {
        $expireTime = $this->date->now()->addMinutes(15);
        if (!$tweets = $this->cache->get('tweets', false)) {
            //Fetch and cache the tweets
            $tweets = $this->makeTweets($params);
            $this->cache->put('tweets', $tweets, $expireTime);
        }

        return collect($tweets);
    }

    /**
     * Factory method for generating new tweets.
     * Repackage Tweet data into slimmed down array.
     *
     * @param $params
     * @return array
     */
    protected function makeTweets($params)
    {
        $tweets = [];
        $tweetParams = [
            'auth_header' => $this->authenticator->makeAuthHeader(),
            'base_url' => $this->config->get('tweetme.oauth_base_url')
        ];
        $tweetParams = array_merge($params, $tweetParams);
        if (count($rawTweets = $this->httpClient->getTweets($tweetParams))) {
            foreach ($rawTweets as $key => $tweet) {
                $tweets[$key] = new Tweet([
                    'username' => $tweet->user->screen_name,
                    'profileImage' => $tweet->user->profile_image_url_https,
                    'tweetContent' => $tweet->text,
                    'dateTweeted' => $tweet->created_at,
                ]);
            }
        }
        return $tweets;
    }
}
