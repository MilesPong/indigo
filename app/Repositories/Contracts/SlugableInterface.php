<?php

namespace App\Repositories\Contracts;

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