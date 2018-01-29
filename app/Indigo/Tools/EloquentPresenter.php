<?php

namespace Indigo\Tools;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

/**
 * Class EloquentPresenter
 * @package Indigo\Tools
 */
class EloquentPresenter
{
    /**
     * Get an item from an array using "dot" notation.
     *
     * @param Model $model
     * @param string $keys
     * @param mixed $default
     * @return Model|mixed
     * @see \Illuminate\Support\Arr::get()
     */
    public static function parseRelationship(Model $model, $keys, $default = null)
    {
        foreach (explode('.', $keys) as $key) {
            if (Arr::accessible($model) && Arr::exists($model, $key)) {
                $model = $model[$key];
            } else {
                return value($default);
            }
        }

        return $model;
    }
}