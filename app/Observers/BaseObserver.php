<?php

namespace App\Observers;

use App\Services\CacheHelper;

/**
 * Class BaseObserver
 * @package App\Observers
 */
class BaseObserver
{
    /**
     * @var CacheHelper
     */
    protected $cacheHelper;

    /**
     * PostObserver constructor.
     * @param CacheHelper $cacheHelper
     */
    public function __construct(CacheHelper $cacheHelper)
    {
        $this->cacheHelper = $cacheHelper;
    }
}