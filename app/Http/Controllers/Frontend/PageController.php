<?php

namespace App\Http\Controllers\Frontend;

use App\Events\ViewedEvent;
use App\Repositories\Contracts\PageRepository;

/**
 * Class PageController
 * @package App\Http\Controllers\Frontend
 */
class PageController extends FrontendController
{
    /**
     * @var \App\Repositories\Contracts\PageRepository
     */
    protected $pageRepository;

    /**
     * PageController constructor.
     * @param \App\Repositories\Contracts\PageRepository $pageRepository
     */
    public function __construct(PageRepository $pageRepository)
    {
        $this->pageRepository = $pageRepository;
        $this->disableApiResource($this->pageRepository);
    }

    /**
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($slug)
    {
        $page = $this->pageRepository->getBySlug($slug);

        event(new ViewedEvent($page));

        return view('pages.show', compact('page'));
    }
}
