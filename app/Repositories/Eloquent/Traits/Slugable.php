<?php

namespace App\Repositories\Eloquent\Traits;

use Carbon\Carbon;

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

            $slug = str_slug($name);
            if ($this->slugExists($slug, $keySlug)) {
                $slug = $this->unique($name);
            }

            array_set($attributes, $keySlug, $slug);
        }

        return $attributes;
    }

    /**
     * @param $slug
     * @param string $column
     * @return mixed
     */
    protected function slugExists($slug, $column = 'slug')
    {
        return $this->model->where($column, $slug)->exists();
    }

    /**
     * @param $value
     * @return string
     */
    protected function unique($value)
    {
        return str_slug($value) . '-' . Carbon::now()->toDateTimeString();
    }
}