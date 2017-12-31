<?php

namespace App\Repositories\Eloquent;

use App\Models\Tag;
use App\Repositories\Contracts\TagRepository;
use App\Repositories\Eloquent\Traits\HasPost;
use App\Repositories\Eloquent\Traits\Slugable;
use App\Http\Resources\Tag as TagResource;

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
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create(array $attributes)
    {
        $attributes = $this->preHandleData($attributes);

        return parent::create($attributes);
    }

    /**
     * @param array $attributes
     * @return array
     */
    protected function preHandleData(array $attributes)
    {
        $attributes = $this->autoSlug($attributes);

        return $attributes;
    }

    /**
     * @param array $attributes
     * @param $id
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    public function update(array $attributes, $id)
    {
        $attributes = $this->preHandleData($attributes);

        return parent::update($attributes, $id);
    }
}
