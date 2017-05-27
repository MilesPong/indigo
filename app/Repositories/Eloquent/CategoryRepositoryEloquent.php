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
}
