<?php

namespace App\Http\Controllers\Frontend;

use App\Events\ViewedEvent;
use App\Repositories\Contracts\PostRepository;

/**
 * Class PostController
 * @package App\Http\Controllers\Frontend
 */
class PostController extends FrontendController
{
    /**
     * @var \App\Repositories\Contracts\PostRepository
     */
    protected $postRepository;

    /**
     * PostController constructor.
     * @param \App\Repositories\Contracts\PostRepository $postRepository
     */
    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;

        $this->disableApiResource($this->postRepository);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = $this->postRepository->frontendPaginate();

        return view('posts.index', compact('posts'));
    }

    /**
     * Display the specified resource.
     *
     * @param  string $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $post = $this->postRepository->getBySlug($slug);

        $previous = $this->postRepository->previous($post);
        $next = $this->postRepository->next($post);

        event(new ViewedEvent($post));

        return view('posts.show', compact('post', 'previous', 'next'));
    }
}
