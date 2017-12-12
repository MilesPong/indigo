<?php

namespace App\Http\Controllers\Frontend;

use App\Events\PostViewEvent;
use App\Http\Controllers\Controller;
use App\Repositories\Contracts\PostRepository;

/**
 * Class PostController
 * @package App\Http\Controllers\Frontend
 */
class PostController extends Controller
{
    /**
     * @var PostRepository
     */
    protected $postRepository;

    /**
     * PostController constructor.
     * @param PostRepository $postRepository
     */
    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = $this->postRepository->paginate();

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

        event(new PostViewEvent($post->id));

        return view('posts.show', compact('post', 'previous', 'next'));
    }
}
