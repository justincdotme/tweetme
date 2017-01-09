<?php

namespace Justincdotme\Tweetme;

class Tweet
{
    protected $text;
    protected $profileImage;
    protected $username;
    protected $dateTweeted;

    public function __construct()
    {

    }

    /**
     * @return mixed
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param mixed $text
     */
    public function setText( $text )
    {
        $this->text = $text;
    }

    /**
     * @return mixed
     */
    public function getProfileImage()
    {
        return $this->profileImage;
    }

    /**
     * @param mixed $profileImage
     */
    public function setProfileImage( $profileImage )
    {
        $this->profileImage = $profileImage;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername( $username )
    {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getDateTweeted()
    {
        return $this->dateTweeted;
    }

    /**
     * @param mixed $dateTweeted
     */
    public function setDateTweeted( $dateTweeted )
    {
        $this->dateTweeted = $dateTweeted;
    }


    //TODO - Find other text that needs replacin'

    /**
     * Replace URLs with links.
     *
     * @param $text
     * @return mixed
     */
    protected function activateLinks( $text )
    {
        return preg_replace( '!(http|https)(s)?:\/\/[a-zA-Z0-9.?&_/]+!', "<a target=\"_BLANK\" href=\"\\0\">\\0</a>", $text );
    }

    /**
     * Replace #hashtags with links.
     *
     * @param $text
     * @return mixed
     */
    protected function activateHashTags( $text )
    {
        return preg_replace( '/(^|\s)#(\w*[a-zA-Z_]+\w*)/', '<a target="_BLANK" href="https://twitter.com/hashtag/\\2?src=hash">\\0</a>', $text );
    }

    /**
     * Format the Tweet date.
     * Old format Wed Aug 29 17:12:58 +0000 2012.
     * New format Wed, Aug 29, 2012
     *
     * @return string
     */
    protected function getFormattedDate()
    {
        $tweetDate = explode( ' ', $this->date );

        return $tweetDate[ 0 ] . ', ' . $tweetDate[ 1 ] . ' ' . $tweetDate[ 2 ] . ', ' . $tweetDate[ 5 ];
    }
}