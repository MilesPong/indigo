<?php

namespace App\Repositories\Contracts;

/**
 * Interface SlugInterface
 * @package App\Repositories\Contracts
 */
interface SlugInterface
{
    /**
     * @param $slug
     * @return mixed
     */
    public function getBySlug($slug);
}