<?php

namespace App\Services;

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
        $key = $this->keyFind($table, $model->id);

        Cache::tags($table)->forget($key);
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

    /**
     * @param $table
     * @return string
     */
    public function keyAll($table)
    {
        return sprintf(self::KEY_FORMAT, $table, 'all');
    }
}