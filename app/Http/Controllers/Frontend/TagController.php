<?php

namespace App\Http\Controllers\Frontend;

use App\Repositories\Contracts\PostRepository;
use App\Repositories\Contracts\TagRepository;

/**
 * Class TagController
 * @package App\Http\Controllers\Frontend
 */
class TagController extends FrontendController
{
    /**
     * @var \App\Repositories\Contracts\TagRepository
     */
    protected $tagRepository;
    /**
     * @var \App\Repositories\Contracts\PostRepository
     */
    protected $postRepository;

    /**
     * TagController constructor.
     * @param \App\Repositories\Contracts\TagRepository $tagRepository
     * @param \App\Repositories\Contracts\PostRepository $postRepository
     */
    public function __construct(TagRepository $tagRepository, PostRepository $postRepository)
    {
        $this->tagRepository = $tagRepository;
        $this->postRepository = $postRepository;

        $this->disableApiResource($this->tagRepository, $this->postRepository);
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
