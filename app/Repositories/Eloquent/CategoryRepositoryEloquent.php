<?php

namespace App\Repositories\Eloquent;

use App\Models\Category;
use App\Repositories\Contracts\CategoryRepository;

/**
 * Class CategoryRepositoryEloquent
 * @package App\Repositories\Eloquent
 */
class CategoryRepositoryEloquent extends Repository implements CategoryRepository
{
    /**
     * @return string
     */
    public function model()
    {
        return Category::class;
    }

    /**
     * @param array $attributes
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function createCategory(array $attributes)
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
    public function updateCategory(array $attributes, $id)
    {
        $attributes = $this->preHandleData($attributes);

        return $this->update($attributes, $id);
    }
}
