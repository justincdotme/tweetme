<?php
/**
 * Created by PhpStorm.
 * User: justin
 * Date: 1/15/17
 * Time: 8:05 AM
 */

namespace Justincdotme\TweetMe;

use Illuminate\Support\Facades\Facade;

class TweetMeFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return TweetMeInterface::class;
    }
}