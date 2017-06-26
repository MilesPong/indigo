<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class CacheHelper
 * @package App\Facades
 */
class CacheHelper extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'cache.helper';
    }
}
