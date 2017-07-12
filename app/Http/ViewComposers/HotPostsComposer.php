<?php

namespace App\Http\ViewComposers;

use App\Repositories\Contracts\PostRepository;
use Illuminate\View\View;

/**
 * Class HotPostsComposer
 * @package App\Http\ViewComposers
 */
class HotPostsComposer
{
    /**
     * @var PostRepository
     */
    protected $postRepo;

    /**
     * HotPostsComposer constructor.
     * @param PostRepository $postRepo
     */
    public function __construct(PostRepository $postRepo)
    {
        $this->postRepo = $postRepo;
    }

    /**
     * @param View $view
     */
    public function compose(View $view)
    {
        $hotPosts = $this->postRepo->hot();

        $view->with('hotPosts', $hotPosts);
    }
}