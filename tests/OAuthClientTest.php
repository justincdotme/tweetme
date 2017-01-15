<?php

class OAuthClientTest extends \PHPUnit_Framework_TestCase
{
    protected $oauth;

    public function __construct($name = null, array $data = array(), $dataName = '')
    {
        $this->configMock = $this->getMockBuilder('Illuminate\Contracts\Config\Repository')->getMock();

        $this->oauth = new Justincdotme\TweetMe\AuthClient\OAuthClient($this->configMock);

        parent::__construct($name, $data, $dataName);
    }

    public function test_make_auth_header_returns_array ()
    {
        $this->assertInternalType('array', $this->oauth->makeAuthHeader());
    }
}