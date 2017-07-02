<?php

namespace App\Observers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;

/**
 * Class PostObserver
 * @package App\Observers
 */
class PostObserver extends BaseObserver
{
    /**
     * @param Post $post
     */
    public function created(Post $post)
    {
        // Flush post pagination cached
        $this->cacheHelper->flushPagination($post);
        $this->flushRelatedData();
    }

    /**
     * @param Post $post
     */
    public function updated(Post $post)
    {
        // Flush single post key
        $this->cacheHelper->flushEntity($post);
        $this->flushRelatedData();
    }

    /**
     * @param Post $post
     */
    public function deleted(Post $post)
    {
        $this->cacheHelper->flushEntity($post);
        $this->flushRelatedData();
        $this->cacheHelper->flushPagination($post);
    }

    protected function flushRelatedData()
    {
        // Flush category 'all' cache
        $this->cacheHelper->flushList(new Category);

        // Flush tag 'all' cache
        $this->cacheHelper->flushList(new Tag);
    }
}