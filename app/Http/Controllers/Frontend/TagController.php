<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Repositories\Contracts\PostRepository;
use App\Repositories\Contracts\TagRepository;

/**
 * Class TagController
 * @package App\Http\Controllers\Frontend
 */
class TagController extends Controller
{
    /**
     * @var TagRepository
     */
    protected $tagRepository;
    /**
     * @var PostRepository
     */
    protected $postRepository;

    /**
     * TagController constructor.
     * @param TagRepository $tagRepository
     * @param PostRepository $postRepository
     */
    public function __construct(TagRepository $tagRepository, PostRepository $postRepository)
    {
        $this->tagRepository = $tagRepository;
        $this->postRepository = $postRepository;
    }

    /**
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($slug)
    {
        $tag = $this->tagRepository->getBySlug($slug);

        $posts = $this->postRepository->paginateOfTag($tag);

        return view('tags.show', compact('tag', 'posts'));
    }
}
