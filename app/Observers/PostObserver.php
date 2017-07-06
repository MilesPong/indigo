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
        $this->flushPost($post);
        $this->flushRelatedData();
    }

    /**
     * @param Post $post
     */
    public function deleted(Post $post)
    {
        $this->flushPost($post);
        $this->flushRelatedData();
        $this->cacheHelper->flushPagination($post);
    }

    /**
     * Flush a single post's data.
     *
     * @param Post $post
     */
    protected function flushPost(Post $post)
    {
        $this->cacheHelper->flushEntity($post);
        $this->cacheHelper->flushContent($post);
    }

    /**
     * Flush category and tag data.
     */
    protected function flushRelatedData()
    {
        // Flush category 'all' cache
        $this->cacheHelper->flushList(new Category);

        // Flush tag 'all' cache
        $this->cacheHelper->flushList(new Tag);
    }
}