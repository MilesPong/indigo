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
    protected $tagRepository;

    /**
     * TagsComposer constructor.
     * @param TagRepository $tagRepository
     */
    public function __construct(TagRepository $tagRepository)
    {
        $this->tagRepository = $tagRepository;
    }

    /**
     * @param View $view
     */
    public function compose(View $view)
    {
        $tags = $this->tagRepository->getResultsHavePosts();

        $view->with('tags', $tags);
    }
}