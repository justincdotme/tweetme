<?php

namespace Justincdotme\TweetMe\HttpClient;


/**
 * Class CurlHttpClient
 * Http client for Twitter API.
 *
 * TODO - Swap out CURL for Guzzle.
 *
 * @package Justincdotme\TweetMe\HttpClient
 */
class CurlHttpClient implements HttpClientInterface
{
    /**
     * Fetch array of Tweets from Twitter API.
     *
     * @param array $params
     * @return bool|mixed
     */
    public function getTweets(array $params)
    {
        $handle = curl_init();
        curl_setopt(
            $handle,
            CURLOPT_HTTPHEADER,
            $params['auth_header']
        );
        curl_setopt($handle, CURLOPT_HEADER, false);
        curl_setopt($handle, CURLOPT_URL, $params['base_url']);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);

        $tweets = curl_exec($handle);
        curl_close($handle);
        $tweets = json_decode($tweets);
        if (isset($tweets->errors)) {
            return [];
        }

        return $tweets;

    }
}