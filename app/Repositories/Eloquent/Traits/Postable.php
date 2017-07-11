<?php

namespace App\Repositories\Eloquent\Traits;

use App\Repositories\Contracts\PostRepository;
use App\Scopes\PublishedScope;

/**
 * Trait Postable
 * @package App\Repositories\Eloquent\Traits
 */
trait Postable
{
    use Cacheable;

    /**
     * @var PostRepository
     */
    protected $postRepo;

    /**
     * @param array $columns
     * @return mixed
     */
    public function allWithPostCount($columns = ['*'])
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

    /**
     * @param $slug
     * @return array
     */
    public function getWithPosts($slug)
    {
        $model = $this->findBy('slug', $slug);

        // Call relationship $category->posts()
        $relation = call_user_func([$model, 'posts']);

        if (isAdmin()) {
            $relation->withoutGlobalScope(PublishedScope::class);
        }

        // Relationship default set to no cache
        $postsPagination = $relation->paginate($this->getDefaultPerPage(), ['slug']);

        $items = $postsPagination->getCollection()->map(function ($post) {
            return $this->getPostRepo()->getBySlug($post->slug);
        });

        return [$model, $postsPagination->setCollection($items)];
    }

    /**
     * @return PostRepository|\Illuminate\Foundation\Application|mixed
     */
    protected function getPostRepo()
    {
        if (is_null($this->postRepo)) {
            $this->postRepo = app(PostRepository::class);
        }

        return $this->postRepo;
    }
}