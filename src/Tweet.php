<?php

namespace Justincdotme\TweetMe;

/**
 * Class Tweet
 * Represents a Tweet.
 * Simple DTO with formatting methods.
 *
 * @package Justincdotme\TweetMe
 */
class Tweet
{
    /**
     * @var mixed
     */
    public $tweetContent;
    /**
     * @var mixed
     */
    public $profileImage;
    /**
     * @var mixed
     */
    public $username;
    /**
     * @var mixed
     */
    public $dateTweeted;

    /**
     * Tweet constructor.
     * @param array $tweetParams
     */
    public function __construct(array $tweetParams)
    {
        $this->tweetContent = $tweetParams['tweetContent'];
        $this->profileImage = $tweetParams['profileImage'];
        $this->username = $tweetParams['username'];
        $this->dateTweeted = $tweetParams['dateTweeted'];
        $this->formatLinks()
            ->formatHashtags()
            ->formatUsernames()
            ->formatDate();
    }

    /**
     * Replace URLs with links.
     *
     * @return mixed
     */
    protected function formatLinks()
    {
        $this->tweetContent = preg_replace(
            '!(http|https)(s)?:\/\/[a-zA-Z0-9.?&_/]+!', "<a target=\"_BLANK\" href=\"\\0\">\\0</a>",
            $this->tweetContent
        );
        return $this;
    }

    /**
     * Replace #hashtags with links.
     *
     * @return mixed
     */
    protected function formatHashtags()
    {
        $this->tweetContent = preg_replace(
            '/(^|\s)#(\w*[a-zA-Z_]+\w*)/', '<a target="_BLANK" href="https://twitter.com/hashtag/\\2?src=hash">\\0</a>',
            $this->tweetContent
        );
        return $this;
    }

    /**
     * Format @username as an href to profile page.
     *
     * @return mixed
     */
    protected function formatUsernames()
    {
        preg_match_all('/@[a-zA-Z0-9_]+/', $this->tweetContent, $usernames);
        if (!empty($usernames[0])) {
            foreach ($usernames as $username) {
                $username = $username[0];
                $trimmedName = strtolower(ltrim($username, '@'));
                $href = "<a href=\"https://www.twitter.com/$trimmedName\">$username</a>";
                $this->tweetContent = str_replace($username, $href, $this->tweetContent);
            }
        }
        return $this;
    }

    /**
     * Format the Tweet date.
     * New format Wed, Aug 29, 2012.
     * Old format Wed Aug 29 17:12:58 +0000 2012.
     *
     *
     * @return string
     */
    protected function formatDate()
    {
        $tweetDate = explode(' ', $this->dateTweeted);
        $this->dateTweeted = $tweetDate[0] . ', ' . $tweetDate[1] . ' ' . $tweetDate[2] . ', ' . $tweetDate[5];
        return $this;
    }
}