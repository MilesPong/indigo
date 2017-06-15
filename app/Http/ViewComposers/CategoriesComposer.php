<?php

namespace App\Http\ViewComposers;

use App\Repositories\Contracts\CategoryRepository;
use Illuminate\View\View;

/**
 * Class CategoriesComposer
 * @package App\Http\ViewComposers
 */
class CategoriesComposer
{
    /**
     * @var CategoryRepository
     */
    protected $cateRepo;

    /**
     * CategoriesComposer constructor.
     * @param CategoryRepository $cateRepo
     */
    public function __construct(CategoryRepository $cateRepo)
    {
        $this->cateRepo = $cateRepo;
    }

    /**
     * @param View $view
     */
    public function compose(View $view)
    {
        $categories = $this->cateRepo->allWithPostCount();

        $view->with('categories', $categories);
    }
}