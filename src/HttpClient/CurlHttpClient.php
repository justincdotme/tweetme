<?php

namespace Justincdotme\TweetMe\HttpClient;


class CurlHttpClient implements HttpClientInterface
{
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
            return false;
        }
        
        return $tweets;

    }
}