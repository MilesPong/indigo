<?php

namespace App\Repositories\Eloquent;

use App\Http\Resources\Category as CategoryResource;
use App\Models\Category;
use App\Repositories\Contracts\CategoryRepository;
use App\Repositories\Eloquent\Traits\HasPost;
use App\Repositories\Eloquent\Traits\Slugable;

/**
 * Class CategoryRepositoryEloquent
 * @package App\Repositories\Eloquent
 */
class CategoryRepositoryEloquent extends BaseRepository implements CategoryRepository
{
    use Slugable, HasPost;

    /**
     * @return string
     */
    public function model()
    {
        return Category::class;
    }

    /**
     * @return null|string
     */
    public function resource()
    {
        return CategoryResource::class;
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
     * @return mixed
     * @throws \App\Repositories\Exceptions\RepositoryException
     */
    public function update(array $attributes, $id)
    {
        $attributes = $this->preHandleData($attributes);

        return parent::update($attributes, $id);
    }
}
