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
     * @return mixed
     */
    public function getBySlug($slug);
}