<?php

namespace App\Http\Controllers\Frontend;

use App\Repositories\Contracts\PostRepository;
use Illuminate\Http\Request;

/**
 * Class HomeController
 * @package App\Http\Controllers\Frontend
 */
class HomeController extends FrontendController
{
    /**
     * @var \App\Repositories\Contracts\PostRepository
     */
    protected $postRepository;

    /**
     * HomeController constructor.
     * @param \App\Repositories\Contracts\PostRepository $postRepository
     */
    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;

        $this->disableApiResource($this->postRepository);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $queryString = $request->input('q');

        if (!$queryString) {
            return redirect()->route('home');
        }

        $posts = $this->postRepository->search($queryString);

        return view('home.search', compact('posts', 'queryString'));
    }
}
