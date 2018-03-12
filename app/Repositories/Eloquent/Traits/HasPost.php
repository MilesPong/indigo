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
     * @see \App\Repositories\Contracts\Helpers\HasPostInterface::getResultsHavePosts()
     */
    public function getResultsHavePosts($columns = ['*'])
    {
        return $this->scopeQuery(function ($query) {
            return $query->whereHas('posts');
        })
            ->withCount('posts')
            ->findAll($columns);
    }
}