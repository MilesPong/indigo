<?php

namespace App\Repositories\Eloquent;

use App\Http\Resources\Tag as TagResource;
use App\Models\Tag;
use App\Repositories\Contracts\TagRepository;
use App\Repositories\Eloquent\Traits\HasPost;
use App\Repositories\Eloquent\Traits\Slugable;

/**
 * Class TagRepositoryEloquent
 * @package App\Repositories\Eloquent
 */
class TagRepositoryEloquent extends BaseRepository implements TagRepository
{
    use Slugable, HasPost;

    /**
     * @return string
     */
    public function model()
    {
        return Tag::class;
    }

    /**
     * @return null|string
     */
    public function resource()
    {
        return TagResource::class;
    }

    /**
     * @param array $attributes
     * @return mixed
     * @throws \App\Repositories\Exceptions\RepositoryException
     */
    public function create(array $attributes)
    {
        $attributes = $this->preHandleData($attributes);

        return parent::create($attributes);
    }

    /**
     * @param array $attributes
     * @return array|mixed
     */
    protected function preHandleData(array $attributes)
    {
        return $attributes;
    }

    /**
     * @param array $attributes
     * @param $id
     * @return mixed
     * @throws \App\Repositories\Exceptions\RepositoryException
     */
    public function update(array $attributes, $id)
    {
        $attributes = $this->preHandleData($attributes);

        return parent::update($attributes, $id);
    }
}
