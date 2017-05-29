<?php

namespace App\Repositories\Eloquent;

use App\Models\Tag;
use App\Repositories\Contracts\TagRepository;

/**
 * Class TagRepositoryEloquent
 * @package App\Repositories\Eloquent
 */
class TagRepositoryEloquent extends Repository implements TagRepository
{
    /**
     * @return string
     */
    public function model()
    {
        return Tag::class;
    }

    /**
     * @param array $attributes
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function createTag(array $attributes)
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
        if (array_get($attributes, 'slug') == null) {
            $name = array_get($attributes, 'name');
            array_set($attributes, 'slug', str_slug($name));
        }

        return $attributes;
    }

    /**
     * @param array $attributes
     * @param $id
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    public function updateTag(array $attributes, $id)
    {
        $attributes = $this->preHandleData($attributes);

        return $this->update($attributes, $id);
    }
}
