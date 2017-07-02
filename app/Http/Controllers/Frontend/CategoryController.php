<?php

namespace App\Http\Controllers\Frontend;

use App\Repositories\Contracts\CategoryRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    /**
     * @var CategoryRepository
     */
    protected $cateRepo;

    /**
     * CategoryController constructor.
     * @param $cateRepo
     */
    public function __construct(CategoryRepository $cateRepo)
    {
        $this->cateRepo = $cateRepo;
    }

    /**
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($slug)
    {
        list($category, $posts) = $this->cateRepo->getWithPosts($slug);

        return view('categories.show', compact('posts', 'category'));
    }
}
