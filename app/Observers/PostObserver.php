<?php

namespace App\Observers;

use App\Models\Post;
use App\Services\CacheHelper;
use Illuminate\Support\Facades\Cache;

class PostObserver
{
    public function created(Post $post)
    {
        // Flush post pagination cached
        CacheHelper::flushPagination($post);
    }

    public function updated(Post $post)
    {
        // Flush single post key
        CacheHelper::flushEntity($post);
    }

    public function deleted(Post $post)
    {
        CacheHelper::flushEntity($post);
        CacheHelper::flushPagination($post);
    }
}