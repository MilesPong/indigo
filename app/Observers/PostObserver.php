<?php

namespace App\Observers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Services\CacheHelper;

/**
 * Class PostObserver
 * @package App\Observers
 */
class PostObserver
{
    /**
     * @var CacheHelper
     */
    protected $cacheHelper;

    /**
     * PostObserver constructor.
     * @param CacheHelper $cacheHelper
     */
    public function __construct(CacheHelper $cacheHelper)
    {
        $this->cacheHelper = $cacheHelper;
    }

    /**
     * @param Post $post
     */
    public function created(Post $post)
    {
        // Flush post pagination cached
        $this->cacheHelper->flushPagination($post);
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
        // Flush categoriy 'all' cache
        $this->cacheHelper->flushList(new Category);

        // Flush tag 'all' cache
        $this->cacheHelper->flushList(new Tag);
    }
}