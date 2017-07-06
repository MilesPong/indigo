<?php

namespace App\Services;

use App\Contracts\ContentableInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

/**
 * Class CacheHelper
 * @package App\Services
 */
class CacheHelper
{
    /**
     * Key's format
     */
    const KEY_FORMAT = '%s:%s';

    /**
     * @param Model $model
     */
    public function flushPagination(Model $model)
    {
        if (!$this->isAllowCache()) {
            return;
        }

        $tags = $this->tagPaginate($model->getTable());

        Cache::tags($tags)->flush();
    }

    /**
     * @return mixed
     */
    public function isAllowCache()
    {
        return config('blog.cache.enable');
    }

    /**
     * @param $table
     * @return string
     */
    public function tagPaginate($table)
    {
        return $table . '-paginate';
    }

    /**
     * @param Model $model
     */
    public function flushEntity(Model $model)
    {
        if (!$this->isAllowCache()) {
            return;
        }

        $table = $model->getTable();
        $key = $this->keySlug($table, $model->slug);

        Cache::tags($table)->forget($key);
    }

    /**
     * @param $table
     * @param $slug
     * @return string
     */
    public function keySlug($table, $slug)
    {
        return sprintf(self::KEY_FORMAT, $table, md5($table . ':' . $slug));
    }

    /**
     * @param Model $model
     */
    public function flushList(Model $model)
    {
        if (!$this->isAllowCache()) {
            return;
        }

        $table = $model->getTable();
        $key = $this->keyAll($table);

        Cache::tags($table)->forget($key);
    }

    /**
     * @param $table
     * @return string
     */
    public function keyAll($table)
    {
        return sprintf(self::KEY_FORMAT, $table, 'all');
    }

    /**
     * Set forever cache of content.
     *
     * @param ContentableInterface $contentable
     * @return mixed
     */
    public function cacheContent(ContentableInterface $contentable)
    {
        return Cache::rememberForever($this->getContentCacheKey($contentable),
            function () use ($contentable) {
                return app(MarkDownParser::class)->md2html($contentable->getRawContent());
            });
    }

    /**
     * Get content cache key.
     *
     * @param ContentableInterface $contentable
     * @return string
     */
    protected function getContentCacheKey(ContentableInterface $contentable)
    {
        return sprintf('contents:%s', $contentable->getContentId());
    }

    /**
     * Forget cache key of content.
     *
     * @param ContentableInterface $contentable
     */
    public function flushContent(ContentableInterface $contentable)
    {
        Cache::forget($this->getContentCacheKey($contentable));
    }

    /**
     * @param $table
     * @param $id
     * @return string
     */
    public function keyFind($table, $id)
    {
        return sprintf(self::KEY_FORMAT, $table, $id);
    }

    /**
     * @param $table
     * @return string
     */
    public function keyPaginate($table)
    {
        return sprintf(self::KEY_FORMAT, $table, 'paginate-' . request()->input('page', 1));
    }
}