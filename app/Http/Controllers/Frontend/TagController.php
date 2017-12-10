<?php

namespace App\Http\Controllers\Frontend;

use App\Repositories\Contracts\TagRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TagController extends Controller
{
    /**
     * @var TagRepository
     */
    protected $tagRepo;

    /**
     * TagController constructor.
     * @param TagRepository $tagRepo
     */
    public function __construct(TagRepository $tagRepo)
    {
        $this->tagRepo = $tagRepo;
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        list($tag, $posts) = $this->tagRepo->getWithPosts($id);

        return view('tags.show', compact('tag', 'posts'));
    }
}
