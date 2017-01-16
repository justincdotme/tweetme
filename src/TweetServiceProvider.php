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
            'Justincdotme\TweetMe\AuthClient\TwitterOAuthClientInterface',
            'Justincdotme\TweetMe\AuthClient\TwitterOAuthClient'
        );

        $this->app->bind(
            'Justincdotme\TweetMe\TweetMeInterface',
            'Justincdotme\TweetMe\TweetMe'
        );

        $this->app->bind(
            'Justincdotme\TweetMe\HttpClient\HttpClientInterface',
            'Justincdotme\TweetMe\HttpClient\CurlHttpClient'
        );
    }
}
