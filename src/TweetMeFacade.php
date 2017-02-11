<?php
/**
 * Created by PhpStorm.
 * User: justin
 * Date: 1/15/17
 * Time: 8:05 AM
 */

namespace Justincdotme\TweetMe;

use Illuminate\Support\Facades\Facade;

/**
 * Class TweetMeFacade
 * Facade Accessor for TweetMe.
 *
 * @package Justincdotme\TweetMe
 */
class TweetMeFacade extends Facade
{
    /**
     * @return mixed
     */
    protected static function getFacadeAccessor()
    {
        return app()->make(TweetMeInterface::class);
    }
}