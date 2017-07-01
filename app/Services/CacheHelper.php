<?php

namespace App\Services;

use Doctrine\Instantiator\Exception\InvalidArgumentException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

/**
 * Class CacheHelper
 * @package App\Services
 */
class CacheHelper
{
    /**
     * Cache keys map
     */
    const KEYS_MAP = [
        'paginate' => [
            'tag_name' => 'paginate',
            'key_format' => '%s:%s'
        ],
        'find' => [
            'tag_name' => 'find',
            'key_format' => '%s:%s'
        ],
        'all' => [
            'tag_name' => 'all',
            'key_format' => '%s:%s'
        ],
    ];

    /**
     * @param Model $model
     */
    public static function flushPagination(Model $model)
    {
        if (!self::isAllowCache()) {
            return;
        }

        $tags = self::getMethodTag($model->getTable(), 'paginate');

        Cache::tags($tags)->flush();
    }

    /**
     * @return mixed
     */
    public static function isAllowCache()
    {
        return config('blog.cache.enable');
    }

    /**
     * @param $table
     * @param $method
     * @return string
     */
    protected static function getMethodTag($table, $method)
    {
        return $table . '-' . array_get(self::KEYS_MAP, $method . '.tag_name');
    }

    /**
     * @param Model $model
     */
    public static function flushEntity(Model $model)
    {
        if (!self::isAllowCache()) {
            return;
        }

        list($key, $tags) = self::getKeyAndTags($model, 'find');

        Cache::tags($tags)->forget($key);
    }

    /**
     * @param $model
     * @param $method
     * @return array
     */
    protected static function getKeyAndTags($model, $method)
    {
        return [
            self::getKey($model, $method, $model->id),
            self::getTags($model->getTable(), $method)
        ];
    }

    /**
     * @param $model
     * @param $method
     * @param null $id
     * @return string
     */
    public static function getKey($model, $method, $id = null)
    {
        $format = array_get(self::KEYS_MAP, $method . '.key_format');

        $table = $model->getTable();

        switch ($method) {
            case 'all':
                $key = sprintf($format, $table, 'all');
                break;
            case 'find':
                $key = sprintf($format, $table, $id);
                break;
            case 'paginate':
                $key = sprintf($format, $table, 'paginate-' . request()->input('page', 1));
                break;
            default:
                throw new InvalidArgumentException();
        }

        return $key;
    }

    /**
     * @param $table
     * @param $method
     * @return array
     */
    public static function getTags($table, $method)
    {
        return [
            $table,
            self::getMethodTag($table, $method)
        ];
    }
}