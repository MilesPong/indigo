<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Repositories\Contracts\CategoryRepository;
use App\Repositories\Contracts\PostRepository;

class CategoryController extends Controller
{
    /**
     * @var CategoryRepository
     */
    protected $categoryRepository;
    /**
     * @var PostRepository
     */
    protected $postRepository;

    /**
     * CategoryController constructor.
     * @param CategoryRepository $categoryRepository
     * @param PostRepository $postRepository
     */
    public function __construct(CategoryRepository $categoryRepository, PostRepository $postRepository)
    {
        $this->categoryRepository = $categoryRepository;
        $this->postRepository = $postRepository;
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
