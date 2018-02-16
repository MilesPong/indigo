<?php

namespace App\Repositories\Contracts\Helpers;

/**
 * Interface SlugableInterface
 * @package App\Repositories\Contracts
 */
interface SlugableInterface
{
    /**
     * @param $slug
     * @param string $field
     * @return mixed
     */
    public function getBySlug($slug, $field = 'slug');
}