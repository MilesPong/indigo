<?php

namespace App\Http\Controllers\Frontend;

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
        // TODO paginate page should be dynamic set in config, e.g. config('app.post.perPage', 5)
        $posts = $this->postRepo
            ->with(['category', 'tags', 'author'])
            ->paginate(5);

        return view('posts.index', compact('posts'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = $this->postRepo
            ->with(['category', 'tags', 'author'])
            ->find($id);

        return view('posts.show', compact('post'));
    }
}
