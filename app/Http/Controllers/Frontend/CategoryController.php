<?php

namespace App\Http\Controllers\Frontend;

use App\Repositories\Contracts\CategoryRepository;
use App\Repositories\Contracts\PostRepository;

/**
 * Class CategoryController
 * @package App\Http\Controllers\Frontend
 */
class CategoryController extends FrontendController
{
    /**
     * @var \App\Repositories\Contracts\CategoryRepository
     */
    protected $categoryRepository;
    /**
     * @var \App\Repositories\Contracts\PostRepository
     */
    protected $postRepository;

    /**
     * CategoryController constructor.
     * @param \App\Repositories\Contracts\CategoryRepository $categoryRepository
     * @param \App\Repositories\Contracts\PostRepository $postRepository
     */
    public function __construct(CategoryRepository $categoryRepository, PostRepository $postRepository)
    {
        $this->categoryRepository = $categoryRepository;
        $this->postRepository = $postRepository;

        $this->disableApiResource($this->categoryRepository, $this->postRepository);
    }

    /**
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($slug)
    {
        $category = $this->categoryRepository->getBySlug($slug);

        $posts = $this->postRepository->paginateOfCategory($category);

        return view('categories.show', compact('posts', 'category'));
    }
}
