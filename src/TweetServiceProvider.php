<?php

namespace Justincdotme\TweetMe;

/**
 * Class TweetServiceProvider
 * Laravel 5 Service Provider
 *
 * @package Justincdotme\TweetMe
 */
class TweetServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/tweetme.php' => config_path('tweetme.php'),
            __DIR__ . '/../config/.env.tweetme' => base_path('.env.tweetme')
        ]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            \Justincdotme\TweetMe\AuthClient\TwitterOAuthClientInterface::class,
            \Justincdotme\TweetMe\AuthClient\TwitterOAuthClient::class
        );

        $this->app->bind(
            \Justincdotme\TweetMe\TweetMeInterface::class,
            \Justincdotme\TweetMe\TweetMe::class
        );

        $this->app->bind(
            \Justincdotme\TweetMe\HttpClient\HttpClientInterface::class,
            \Justincdotme\TweetMe\HttpClient\CurlHttpClient::class
        );
    }
}
