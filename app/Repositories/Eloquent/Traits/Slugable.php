<?php

namespace App\Repositories\Eloquent\Traits;

/**
 * Trait Slugable
 * @package App\Repositories\Eloquent\Traits
 */
trait Slugable
{
    /**
     * Auto create slug if request slug is null
     *
     * @param $attributes
     * @param string $keyName
     * @param string $keySlug
     * @return mixed
     */
    public function autoSlug($attributes, $keyName = 'name', $keySlug = 'slug')
    {
        if (array_get($attributes, $keySlug) == null) {
            $name = array_get($attributes, $keyName);
            array_set($attributes, $keySlug, str_slug($name));
        }

        return $attributes;
    }
}