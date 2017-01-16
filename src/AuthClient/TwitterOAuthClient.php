<?php

namespace Justincdotme\TweetMe\AuthClient;

use Illuminate\Contracts\Config\Repository as Config;

/**
 * Class TwitterOAuthClient
 * A utility class for Twitter OAuth.
 * Authenticate against Twitter via OAuth.
 *
 * @package Justincdotme\TweetMe\AuthClient
 */
class TwitterOAuthClient implements TwitterOAuthClientInterface
{
    /**
     * @var array
     */
    protected $oauth;
    /**
     * @var string
     */
    protected $baseInfo;
    /**
     * @var mixed
     */
    protected $baseUrl;
    /**
     * @var string
     */
    protected $compositeKey;
    /**
     * @var string
     */
    protected $oauthSignature;
    /**
     * @var mixed
     */
    protected $oauthConsumerSecret;
    /**
     * @var mixed
     */
    protected $oauthAccessTokenSecret;
    /**
     * @var Config
     */
    protected $config;

    /**
     * TwitterOAuthClient constructor.
     * @param Config $config
     */
    public function __construct(Config $config)
    {
        $this->config = $config;
        $this->oauth = [
            'oauth_consumer_key' => $this->config->get('tweetme.oauth_consumer_key'),
            'oauth_nonce' => time(),
            'oauth_signature_method' => 'HMAC-SHA1',
            'oauth_timestamp' => time(),
            'oauth_token' => $this->config->get('tweetme.oauth_access_token'),
            'oauth_version' => '1.0'
        ];

        $this->oauthConsumerSecret = $this->config->get('tweetme.oauth_consumer_secret');
        $this->oauthAccessTokenSecret = $this->config->get('tweetme.oauth_access_token_secret');

        $this->baseUrl = $this->config->get('tweetme.oauth_base_url');
        $this->baseInfo = $this->makeBaseString($this->baseUrl, $this->oauth);
        $this->compositeKey = $this->makeCompositeKey([
            $this->config->get('tweetme.oauth_consumer_secret'),
            $this->config->get('tweetme.oauth_access_token_secret')
        ]);
        $this->oauthSignature = $this->makeOauthSignature($this->baseInfo, $this->compositeKey);
        $this->oauth['oauth_signature'] = $this->oauthSignature;
    }

    /**
     * Create base string for oAuth request.
     * [https://dev.twitter.com/oauth/overview/authorizing-requests]
     *
     * @return string
     */
    protected function makeBaseString()
    {
        $parametersContainer = [];
        //Twitter requires parameters to be sorted alphabetically by key.
        ksort($this->oauth);
        foreach ($this->oauth as $key => $value) {
            //Returns strings as "key=value"
            array_push($parametersContainer, "$key=" . rawurlencode($value));
        }
        return "GET&" . rawurlencode($this->baseUrl) . '&' . rawurlencode(implode('&', $parametersContainer));
    }

    /**
     * Generate the oAuth header.
     * [https://dev.twitter.com/oauth/overview/authorizing-requests]
     *
     * @return string
     */
    public function makeAuthHeader()
    {
        $header = 'Authorization: OAuth ';
        $values = [];
        foreach ($this->oauth as $key => $value) {
            array_push($values, "$key=\"" . rawurlencode($value) . "\"");
        }
        $header .= implode(', ', $values);
        return [
            $header,
            'Expect:'
        ];
    }

    /**
     * Create the composite key.
     * Combines consumer_secret and oauth_access_token_secret.
     *
     * @return string
     */
    protected function makeCompositeKey()
    {
        $compositeKey = rawurlencode($this->oauthConsumerSecret);
        $compositeKey .= '&' . rawurlencode($this->oauthAccessTokenSecret);
        return $compositeKey;
    }

    /**
     * Sign the composite key+base info.
     * Return Open AuthClient signature for use in cURL request.
     *
     * @param $base_info
     * @param $composite_key
     * @return string
     */
    protected function makeOauthSignature($base_info, $composite_key)
    {
        return base64_encode(hash_hmac('sha1', $base_info, $composite_key, true));
    }
}