<?php

namespace Indigo\Post;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

/**
 * Class PostViewCounter
 * @package Indigo\Post
 */
class PostViewCounter
{
    /**
     * For session
     *
     * @var
     */
    public $strict_mode;
    /**
     * @var
     */
    protected $timeout;
    /**
     * @var
     */
    protected $id;
    /**
     * @var Request
     */
    protected $request;
    /**
     * Cache key
     *
     * @var
     */
    private $key;
    /**
     * @var
     */
    private $cacheKey;

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
        $this->strict_mode = $config['strict_mode'];
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
     * Determinate if enable strict mode
     */
    public function enableStrictMode()
    {
        $this->strict_mode = true;
    }

    /**
     * Determinate if disable strict mode
     */
    public function disableStrictMode()
    {
        $this->strict_mode = false;
    }

    /**
     * Main
     *
     * @param $id
     */
    public function run($id)
    {
        $this->id = $id;

        if ($this->strict_mode) {
            if (!$this->isPostViewed() || $this->isLastViewOutdated()) {
                $this->createSession();

                $this->increaseCacheRecord();
            }
        } else {
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
        Cache::increment($this->getPostCacheKey());
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
