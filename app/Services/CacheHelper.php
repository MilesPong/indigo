<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

/**
 * Class CacheHelper
 * @package App\Services
 */
class CacheHelper
{
    /**
     * @var
     */
    protected $key;

    /**
     * @var mixed
     */
    protected $records;

    /**
     * CacheHelper constructor.
     * @param $key
     */
    public function __construct($key = null)
    {
        self::boot();

        $this->setGroupKey($key);

        $this->records = $this->retrieve();
    }

    /**
     *
     */
    public static function boot()
    {

    }

    /**
     * @param null $key
     * @return $this
     */
    protected function setGroupKey($key = null)
    {
        $this->key = $key ?: config('blog.cache.group_key', 'repository-cache-keys');

        return $this;
    }

    /**
     * @return mixed
     */
    public function retrieve()
    {
        return Cache::get($this->key);
    }

    /**
     * @param $class
     * @param $method
     * @param $cacheKey
     * @return mixed
     */
    public function createOrUpdate($class, $method, $cacheKey)
    {
        $key = call_user_func_array([$this, 'buildKey'], func_get_args());

        array_set($this->records, $key, Carbon::now()->toDateTimeString());

        return tap($this->records, function ($value) {
            $this->store($value);
        });
    }

    /**
     * @param $value
     */
    protected function store($value)
    {
        Cache::forever($this->key, $value);
    }

    /**
     * @param $class
     * @param $method
     * @param null $specificKey
     * @return mixed
     */
    public function forget($class, $method, $specificKey = null)
    {
        $key = $this->buildKey($class, $method, $specificKey);

        array_forget($this->records, $key);

        return tap($this->records, function ($value) {
            $this->store($value);
        });
    }

    /**
     * @param $class
     * @param $method
     * @param null $cacheKey
     * @return string
     */
    protected function buildKey($class, $method, $cacheKey = null)
    {
        // TODO to verify
        return implode('.', func_get_args());

        // return $class . '.' . $method . '.' . $cacheKey;
    }
}