<?php

namespace Justincdotme\TweetMe;

class TweetServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            'Justincdotme\TweetMe\AuthClient\AuthClientInterface',
            'Justincdotme\TweetMe\AuthClient\OAuthClient'
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
