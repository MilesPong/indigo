<?php

namespace App\Repositories\Eloquent\Traits;

use App\Scopes\PublishedScope;

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
            ->withCount([
                'posts' => function ($query) {
                    if (isAdmin()) {
                        $query->withoutGlobalScope(PublishedScope::class);
                    }
                }
            ])
            ->all($columns);
    }
}