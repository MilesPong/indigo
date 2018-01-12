<?php

namespace App\Repositories\Eloquent\Traits;

/**
 * Trait HasPost
 * @package App\Repositories\Eloquent\Traits
 */
trait HasPost
{
    /**
     * @param array $columns
     * @return mixed
     */
    public function getResultsHavePosts($columns = ['*'])
    {
        return $this->whereHas('posts')
            ->withCount('posts')
            ->findAll($columns);
    }
}