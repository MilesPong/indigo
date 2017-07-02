<?php

namespace App\Repositories\Contracts;

use Closure;
use Illuminate\Cache\CacheManager;

/**
 * Interface CacheableInterface
 * @package App\Repositories\Contracts
 */
interface CacheableInterface
{
    /**
     * @param $key
     * @param Closure $callback
     * @param $minutes
     * @return mixed
     */
    public function remember($key, Closure $callback, $minutes);

    /**
     * @return mixed
     */
    public function getCacheMinutes();

    /**
     * @param $name
     * @return mixed
     */
    public function getCacheKey($name);

    /**
     * @return mixed
     */
    public function getCacheRepository();

    /**
     * @param CacheManager $cache
     * @return mixed
     */
    public function setCacheRepository(CacheManager $cache);

    /**
     * @param $minutes
     * @return mixed
     */
    public function setCacheMinutes($minutes);

    /**
     * @param bool $status
     * @return mixed
     */
    public function skipCache($status = true);

    /**
     * @return mixed
     */
    public function isAllowedCache();

    /**
     * @return mixed
     */
    public function isSkippedCache();

    /**
     * @param bool $status
     * @return mixed
     */
    public function setForever($status = true);
}
