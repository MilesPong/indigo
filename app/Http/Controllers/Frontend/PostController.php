<?php

namespace App\Http\Controllers\Frontend;

use App\Events\PostViewEvent;
use App\Repositories\Contracts\PostRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PostController extends Controller
{
    /**
     * @var PostRepository
     */
    protected $postRepo;

    /**
     * PostController constructor.
     * @param PostRepository $postRepo
     */
    public function __construct(PostRepository $postRepo)
    {
        $this->postRepo = $postRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = $this->postRepo->lists();

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
        $post = $this->postRepo->getBySlug($slug);

        $previous = $this->postRepo->previous($post);
        $next = $this->postRepo->next($post);

        event(new PostViewEvent($post->id));

        return view('posts.show', compact('post', 'previous', 'next'));
    }
}
