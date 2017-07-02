<?php

namespace App\Repositories\Eloquent\Traits;

use App\Services\CacheHelper;
use Closure;
use Illuminate\Cache\CacheManager;

/**
 * Trait Cacheable
 * @package App\Repositories\Eloquent\Traits
 */
trait Cacheable
{
    /**
     * @var
     */
    protected $cacheMinutes;

    /**
     * @var bool
     */
    protected $skipCache = false;

    /**
     * @var CacheManager
     */
    protected $cache;

    /**
     * @var array
     */
    protected $tags = [];

    /**
     * @param CacheManager $cache
     * @return $this
     */
    public function setCacheRepository(CacheManager $cache)
    {
        $this->cache = $cache;

        return $this;
    }

    /**
     * @return CacheHelper
     */
    protected function getCacheHelper()
    {
        return new CacheHelper();
    }

    /**
     * @param bool $status
     * @return $this
     */
    public function skipCache($status = true)
    {
        $this->skipCache = $status;

        return $this;
    }

    /**
     * @param null $perPage
     * @param array $columns
     * @return mixed
     */
    public function paginate($perPage = null, $columns = ['*'])
    {
        $table = $this->getModelTable();

        $key = $this->getCacheHelper()->keyPaginate($table);

        array_push($this->tags, $this->getCacheHelper()->tagPaginate($table));

        return $this->getIfCacheable(__FUNCTION__, func_get_args(), $key);
    }

    /**
     * @param $method
     * @param $args
     * @param $key
     * @param boolean $ignoreUriQuery
     * @return mixed
     */
    private function getIfCacheable($method, $args, $key = null, $ignoreUriQuery = true)
    {
        if (!$this->isAllowedCache()) {
            return call_user_func_array([$this, 'parent::' . $method], $args);
        }

        $key = $key ?: $this->getCacheKey($method, $args, $ignoreUriQuery);

        return $this->remember($key,
            function () use ($method, $args) {
                return call_user_func_array([$this, 'parent::' . $method], $args);
            });
    }

    /**
     * @return bool
     */
    public function isAllowedCache()
    {
        return config('blog.cache.enable', true) && !$this->isSkippedCache() && !isAdmin();
    }

    /**
     * @return bool
     */
    public function isSkippedCache()
    {
        return $this->skipCache;
    }

    /**
     * @param $key
     * @param Closure $callback
     * @param null $minutes
     * @return mixed
     */
    public function remember($key, Closure $callback, $minutes = null)
    {
        $minutes = $minutes ?: $this->getCacheMinutes();

        $cache = $this->getCacheRepositoryWithTags();

        return $cache->remember($key, $minutes, $callback);
    }

    /**
     * @return mixed
     */
    public function getCacheMinutes()
    {
        return $this->cacheMinutes ?: config('blog.cache.minutes', 30);
    }

    /**
     * @param $minutes
     * @return $this
     */
    public function setCacheMinutes($minutes)
    {
        $this->cacheMinutes = $minutes;

        return $this;
    }

    /**
     * @return CacheManager|\Illuminate\Foundation\Application|mixed
     */
    public function getCacheRepositoryWithTags()
    {
        $cache = $this->getCacheRepository();

        try {
            $tags = array_merge($this->tags, [$this->getModelTable()]);

            return $cache->tags($tags);
        } catch (\BadMethodCallException $exception) {
            // Not support tags
            // throw $exception;
            return $cache;
        }
    }

    /**
     * @return CacheManager|\Illuminate\Foundation\Application|mixed
     */
    public function getCacheRepository()
    {
        return $this->cache ?: app('cache');
    }

    /**
     * @param $method
     * @param null $args
     * @param boolean $ignoreUriQuery
     * @return string
     */
    public function getCacheKey($method, $args = null, $ignoreUriQuery = true)
    {
        $relationsNameOnly = $this->parseRelations();

        $query = $this->parseQuery($ignoreUriQuery);

        $key = sprintf('%s:%s-%s', $this->getModelTable(), $method,
            md5(serialize($args) . serialize($relationsNameOnly) . $query));

        return $key;
    }

    /**
     * @return array|null
     */
    protected function parseRelations()
    {
        if (empty($this->relations)) {
            return null;
        }

        $names = [];
        foreach ($this->relations as $name => $constraints) {
            if (is_numeric($name)) {
                $name = $constraints;
            }
            array_push($names, $name);
        }

        sort($names);

        return $names;
    }

    /**
     * @param $ignore
     * @return null|string
     */
    protected function parseQuery($ignore)
    {
        if ($ignore) {
            return '';
        }

        return request()->getQueryString();
    }

    /**
     * @param $id
     * @param array $columns
     * @return mixed
     */
    public function find($id, $columns = ['*'])
    {
        $id = (int)$id;

        $key = $this->getCacheHelper()->keyFind($this->getModelTable(), $id);

        return $this->getIfCacheable(__FUNCTION__, [$id, $columns], $key);
    }

    /**
     * @param array $columns
     * @return mixed
     */
    public function all($columns = ['*'])
    {
        $key = $this->getCacheHelper()->keyAll($this->getModelTable());

        return $this->getIfCacheable(__FUNCTION__, func_get_args(), $key);
    }

    // /**
    //  * @param $field
    //  * @param $value
    //  * @param array $columns
    //  * @return mixed
    //  */
    // public function findBy($field, $value, $columns = ['*'])
    // {
    //     return $this->getIfCacheable(__FUNCTION__, func_get_args());
    // }
    //
    // /**
    //  * @param $field
    //  * @param $value
    //  * @param array $columns
    //  * @return mixed
    //  */
    // public function findAllBy($field, $value, $columns = ['*'])
    // {
    //     return $this->getIfCacheable(__FUNCTION__, func_get_args());
    // }
    //
    // /**
    //  * @param array $where
    //  * @param array $columns
    //  * @return mixed
    //  */
    // public function findWhere(array $where, $columns = ['*'])
    // {
    //     return $this->getIfCacheable(__FUNCTION__, func_get_args());
    // }
}
