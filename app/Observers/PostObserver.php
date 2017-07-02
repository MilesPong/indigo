<?php

namespace App\Observers;

use App\Models\Post;
use App\Services\CacheHelper;
use Illuminate\Support\Facades\Cache;

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
    }

    /**
     * @param Post $post
     */
    public function deleted(Post $post)
    {
        $this->cacheHelper->flushEntity($post);
        $this->cacheHelper->flushPagination($post);
    }
}