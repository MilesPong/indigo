<?php

namespace App\Repositories\Eloquent\Traits;

use App\Scopes\PublishedScope;

trait Postable
{
    /**
     * @param array $columns
     * @return mixed
     */
    public function allWithPostCount($columns = ['*'])
    {
        return $this->withCount([
            'posts' => function ($query) {
                if (isAdmin()) {
                    $query->withoutGlobalScope(PublishedScope::class);
                }
            }
        ])
            ->all()
            ->reject(function ($category) {
                return $category->posts_count == 0;
            });
    }

    /**
     * @param $id
     * @return array
     */
    public function getWithPosts($id)
    {
        $model = $this->find($id);

        // Call relationship $category->posts()
        $relation = call_user_func([$model, 'posts']);

        if (isAdmin()) {
            $relation->withoutGlobalScope(PublishedScope::class);
        }

        $posts = $relation->with(['tags', 'category', 'author'])->paginate(5);

        return [$model, $posts];
    }
}