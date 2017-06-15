<?php

namespace App\Http\ViewComposers;

use App\Repositories\Contracts\TagRepository;
use Illuminate\View\View;

/**
 * Class TagsComposer
 * @package App\Http\ViewComposers
 */
class TagsComposer
{

    /**
     * @var TagRepository
     */
    protected $tagRepo;

    /**
     * TagsComposer constructor.
     * @param TagRepository $tagRepo
     */
    public function __construct(TagRepository $tagRepo)
    {
        $this->tagRepo = $tagRepo;
    }

    /**
     * @param View $view
     */
    public function compose(View $view)
    {
        $tags = $this->tagRepo->allWithPostCount();

        $view->with('tags', $tags);
    }
}