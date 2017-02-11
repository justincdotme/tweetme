<?php

namespace Justincdotme\TweetMe;

use Laravel\Lumen\Application as LumenApplication;
use Illuminate\Foundation\Application as LaravelApplication;

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
        $configSrc = dirname(__DIR__) .'/config/tweetme.php';
        if ($this->app instanceof LaravelApplication && $this->app->runningInConsole()) {
            $this->publishes([$configSrc => config_path('tweetme.php')]);
        } elseif ($this->app instanceof LumenApplication) {
            $this->app->configure('tweetme');
        }
        $this->mergeConfigFrom($configSrc, 'tweetme');
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
