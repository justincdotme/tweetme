<?php

namespace Justincdotme\TweetMe\Auth;

use Illuminate\Config\Repository as Config;

class OAuth implements AuthInterface
{
    protected $_oauth;
    protected $_baseInfo;
    protected $_baseUrl;
    protected $_compositeKey;
    protected $_oauthSignature;

    public function __construct(Config $config)
    {
        $this->_config = $config;
        $this->_oauth = [
            'oauth_consumer_key' => $config->get('tweetme.consumer_key'),
            'oauth_nonce' => time(),
            'oauth_signature_method' => 'HMAC-SHA1',
            'oauth_timestamp' => time(),
            'oauth_token' => $config->get('tweetme.oauth_access_token'),
            'oauth_version' => '1.0'
        ];
        $this->_baseUrl = 'https://api.twitter.com/1.1/statuses/user_timeline.json';
        $this->_baseInfo = $this->makeBaseString( $this->_baseUrl, $this->_oauth );
        $this->_compositeKey = $this->makeCompositeKey([
            $config->get('tweetme.consumer_secret'),
            $config->get('tweetme.oauth_access_token_secret')
        ]);
        $this->_oauthSignature = $this->makeOauthSignature( $this->_baseInfo, $this->_compositeKey );
        $this->_oauth[ 'oauth_signature' ] = $this->_oauthSignature;
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
        ksort( $this->_oauth );
        foreach ( $this->_oauth as $key => $value ) {
            //Returns strings as "key=value"
            array_push( $parametersContainer, "$key=" . rawurlencode( $value ) );
        }
        return "GET&" . rawurlencode( $this->_baseUrl ) . '&' . rawurlencode( implode( '&', $parametersContainer ) );
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
        foreach ( $this->_oauth as $key => $value ) {
            array_push( $values, "$key=\"" . rawurlencode( $value ) . "\"" );
        }
        $header .= implode( ', ', $values );
        return [
            $header,
            'Expect:'
        ];
    }

    /**
     * Create the composite key.
     * Combines consumer_secret and oauth_access_token_secret.
     *
     * @param $credentials
     * @return string
     */
    protected function makeCompositeKey($params)
    {
        $compositeKey = rawurlencode( $this->_oauth[ 'consumer_secret' ] );
        $compositeKey .= '&' . rawurlencode( $this->_oauth[ 'oauth_access_token_secret' ] );
        return $compositeKey;
    }

    /**
     * Sign the composite key+base info.
     * Return Open Auth signature for use in cURL request.
     *
     * @param $base_info
     * @param $composite_key
     * @return string
     */
    protected function makeOauthSignature( $base_info, $composite_key )
    {
        return base64_encode( hash_hmac( 'sha1', $base_info, $composite_key, true ) );
    }
}