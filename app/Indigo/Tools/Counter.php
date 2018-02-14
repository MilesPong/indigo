<?php

namespace Indigo\Tools;

use Indigo\Contracts\Counter as CounterContract;
use Indigo\Contracts\Viewable;

/**
 * Class Counter
 * @package App\Indigo\Tools
 */
class Counter implements CounterContract
{
    /**
     * @var \Illuminate\Foundation\Application
     */
    protected $app;
    /**
     * @var
     */
    protected $cacheStore;
    /**
     * @var array
     */
    private $statsData = [];

    /**
     * Counter constructor.
     * @param \Illuminate\Foundation\Application $app
     * @param null|string $store
     */
    public function __construct($app, $store = null)
    {
        $this->app = $app;
        $this->setCacheStore($store);
    }

    /**
     * @param $store
     */
    private function setCacheStore($store)
    {
        $this->cacheStore = $store;
    }

    /**
     * @param \Indigo\Contracts\Viewable $viewable
     * @param int $value
     * @return int|bool
     */
    public function increment(Viewable $viewable, $value = 1)
    {
        $count = $this->get($viewable);

        return tap((int)$count + $value, function ($newValue) use ($viewable) {
            $this->put($viewable, $newValue);
        });
    }

    /**
     * @param \Indigo\Contracts\Viewable $viewable
     * @param int $default
     * @return int
     */
    public function get(Viewable $viewable, $default = 0)
    {
        list($key, $identifier) = $this->parser($viewable);

        $stats = tap($this->getStats($key), function ($value) use ($key) {
            $this->setStatsData($key, $value);
        });

        return $stats[$identifier] ?? $default;
    }

    /**
     * @param \Indigo\Contracts\Viewable $viewable
     * @return array
     */
    protected function parser(Viewable $viewable)
    {
        return [
            $this->getKey($viewable),
            $viewable->getIdentifier()
        ];
    }

    /**
     * @param \Indigo\Contracts\Viewable $viewable
     * @return string
     */
    protected function getKey(Viewable $viewable)
    {
        return get_class($viewable);
    }

    /**
     * @param $key
     * @return array|mixed
     */
    private function getStats($key)
    {
        $stats = $this->getStatsData($key) ?: $this->getAll($key);

        return $stats ?: $this->initializeStats();
    }

    /**
     * @param $key
     * @param null $default
     * @return mixed|null
     */
    private function getStatsData($key, $default = null)
    {
        return $this->statsData[$key] ?? $default;
    }

    /**
     * @param \Indigo\Contracts\Viewable|string $viewable
     * @return mixed
     */
    public function getAll($viewable)
    {
        $key = $this->parseKey($viewable);

        return $this->getCacheRepository()->get($key);
    }

    /**
     * @param $viewable
     * @return string
     */
    private function parseKey($viewable): string
    {
        return is_string($viewable) ? $viewable : $this->getKey($viewable);
    }

    /**
     * @return \Illuminate\Contracts\Cache\Repository
     */
    protected function getCacheRepository()
    {
        return $this->app['cache']->store($this->cacheStore);
    }

    /**
     * @return array
     */
    private function initializeStats()
    {
        return [];
    }

    /**
     * @param $key
     * @param $value
     * @return $this
     */
    private function setStatsData($key, $value)
    {
        $this->statsData[$key] = $value;

        return $this;
    }

    /**
     * @param \Indigo\Contracts\Viewable $viewable
     * @param $value
     */
    public function put(Viewable $viewable, $value)
    {
        list($key, $identifier) = $this->parser($viewable);

        $stats = $this->getStats($key);

        $stats[$identifier] = $value;

        $this->setStatsData($key, $stats);

        $this->getCacheRepository()->forever($key, $stats);
    }

    /**
     * @param \Indigo\Contracts\Viewable $viewable
     */
    public function reset(Viewable $viewable)
    {
        $this->put($viewable, 0);
    }

    /**
     * @param \Indigo\Contracts\Viewable|string $viewable
     * @return bool
     */
    public function resetAll($viewable)
    {
        $key = $this->parseKey($viewable);

        return $this->getCacheRepository()->forget($key);
    }
}