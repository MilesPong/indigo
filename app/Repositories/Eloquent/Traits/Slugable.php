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

            $slug = str_slug_with_cn($name);
            // TODO known bug
            // If update post with deleting original auto-generated slug, slug will generate again
            // and may 'duplicate' in DB. One solution is exclude current record(based on id) while doing update
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
        return str_slug_with_cn($value) . '-' . $this->uniqueChar();
    }

    /**
     * @return string
     */
    protected function uniqueChar()
    {
        return Carbon::now()->timestamp;
    }
}