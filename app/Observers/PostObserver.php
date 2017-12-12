<?php

namespace App\Observers;

use App\Models\Post;

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

    }

    /**
     * @param Post $post
     */
    public function updated(Post $post)
    {

    }

    /**
     * @param Post $post
     */
    public function deleted(Post $post)
    {

    }
}