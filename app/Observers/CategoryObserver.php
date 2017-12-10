<?php

namespace App\Observers;

use App\Models\Category;

/**
 * Class CategoryObserver
 * @package App\Observers
 */
class CategoryObserver extends BaseObserver
{
    /**
     * @param Category $category
     */
    public function updated(Category $category)
    {
        $this->cacheHelper->flushEntity($category);
    }
}