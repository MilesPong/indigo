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
    protected $cateRepository;

    /**
     * @var
     */
    protected $categories;

    /**
     * CategoriesComposer constructor.
     * @param CategoryRepository $cateRepository
     */
    public function __construct(CategoryRepository $cateRepository)
    {
        $this->cateRepository = $cateRepository;
    }

    /**
     * @param View $view
     */
    public function compose(View $view)
    {
        if (!$this->categories) {
            $this->categories = $this->cateRepository->getResultsHavePosts();
        }

        $view->with('categories', $this->categories);
    }
}