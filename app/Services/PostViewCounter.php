<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

/**
 * Class PostViewCounter
 * @package App\Services
 */
class PostViewCounter
{
    /**
     * @var
     */
    protected $timeout; // For session key and cache tag
    /**
     * @var
     */
    protected $id;
    /**
     * @var Request
     */
    protected $request;
    /**
     * @var
     */
    private $key;
    /**
     * @var
     */
    private $cacheKey; // Cache key

    /**
     * PostViewCounter constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->setConfig();
    }

    /**
     * Prepare property
     */
    protected function setConfig()
    {
        // TODO what if config is hack?
        $config = $this->getDefaultConfig();
        $this->timeout = $config['timeout'];
        $this->key = $config['key'];
        $this->cacheKey = $config['cache_key'];
    }

    /**
     * Get default config
     *
     * @return mixed
     */
    protected function getDefaultConfig()
    {
        return config('blog.counter');
    }

    /**
     * Reset timeout
     *
     * @param $timeout
     */
    public function setTimeout($timeout)
    {
        $this->timeout = $timeout;
    }

    /**
     * Main
     *
     * @param $id
     */
    public function run($id)
    {
        $this->id = $id;

        if (!$this->isPostViewed() || $this->isLastViewOutdated()) {
            $this->saveVisitorLog();

            $this->createSession();

            $this->increaseCacheRecord();
        }
    }

    /**
     * Determinate if post is have been viewed
     *
     * @return bool
     */
    protected function isPostViewed()
    {
        return $this->request->session()->has($this->getPostSessionKey());
    }

    /**
     * Get post's session key
     *
     * @return string
     */
    protected function getPostSessionKey()
    {
        return $this->key . '.' . $this->id;
    }

    /**
     * Determinate if post view record is outdated
     *
     * @return bool
     */
    protected function isLastViewOutdated()
    {
        $lastView = $this->request->session()->get($this->getPostSessionKey());

        return ($lastView + $this->timeout) < $this->currentTime();
    }

    /**
     * Return a unix timestamp
     *
     * @return int
     */
    private function currentTime()
    {
        return time();
    }

    /**
     *
     */
    protected function saveVisitorLog()
    {
        // TODO
    }

    /**
     * Create post viewed session
     */
    protected function createSession()
    {
        $this->request->session()->put($this->getPostSessionKey(), $this->currentTime());
    }

    /**
     * Save view record into cache
     */
    protected function increaseCacheRecord()
    {
        $cacheKey = $this->getPostCacheKey();
        if (Cache::tags($this->key)->has($cacheKey)) {
            Cache::tags($this->key)->increment($cacheKey);
        } else {
            Cache::tags($this->key)->forever($cacheKey, 1);
        }
    }

    /**
     * Return post's cache key
     *
     * @return string
     */
    protected function getPostCacheKey()
    {
        return $this->cacheKey . $this->id;
    }
}
