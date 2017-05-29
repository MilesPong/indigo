<?php

namespace App\Repositories\Eloquent;

use App\Models\Post;
use App\Repositories\Contracts\PostRepository;
use App\Repositories\Eloquent\Traits\Slugable;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PostRepositoryEloquent
 * @package App\Repositories\Eloquent
 */
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

    /**
     * @param array $attributes
     * @return Model
     */
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

    /**
     * @param array $attributes
     * @param $id
     * @return \Illuminate\Database\Eloquent\Collection|Model
     */
    public function updatePost(array $attributes, $id)
    {
        $attributes = $this->preHandleData($attributes);

        return $this->update($attributes, $id);
    }

    /**
     * @param $post
     * @param bool $toArray
     * @return mixed
     */
    public function getTags($post, $toArray = true)
    {
        if (!$this->model->exists) {
            $this->model = $this->find($post);
        } elseif ($post instanceof Model) {
            $this->model = $post;
        }

        $tagIds = $this->model->tags()->get()->pluck('pivot.tag_id');

        if ($toArray) {
            return $tagIds->toArray();
        }

        return $tagIds;
    }
}
