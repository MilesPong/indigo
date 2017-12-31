<?php

namespace App\Repositories\Contracts\Helpers;

use Closure;
use Illuminate\Contracts\Cache\Repository as CacheRepository;

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
     * @param CacheRepository $cache
     * @return mixed
     */
    public function setCacheRepository(CacheRepository $cache);

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
