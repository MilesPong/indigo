<?php

namespace App\Repositories\Eloquent;

use App\Models\Post;
use App\Repositories\Contracts\PostRepository;
use App\Repositories\Eloquent\Traits\Slugable;

class PostRepositoryEloquent extends Repository implements PostRepository
{
    use Slugable;

    /**
     * @return string
     */
    public function model()
    {
        return Post::class;
    }

    public function createPost(array $attributes)
    {
        $attributes = $this->preHandleData($attributes);

        return $this->create($attributes);
    }

    /**
     * @param array $attributes
     * @return array
     */
    protected function preHandleData(array $attributes)
    {
        $attributes = $this->autoSlug($attributes, 'title');

        return $attributes;
    }

    public function updatePost(array $attributes, $id)
    {
        $attributes = $this->preHandleData($attributes);

        return $this->update($attributes, $id);
    }
}
