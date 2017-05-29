<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\StoreUpdateTagRequest;
use App\Repositories\Contracts\TagRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TagController extends Controller
{
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tags = $this->tagRepo->paginate();

        return view('admin.tags.index', compact('tags'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.tags.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreUpdateTagRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUpdateTagRequest $request)
    {
        $this->tagRepo->createTag($request->all());

        return redirect()->route('tags.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tag = $this->tagRepo->find($id);

        return response($tag);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tag = $this->tagRepo->find($id);

        return view('admin.tags.edit', compact('tag'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  StoreUpdateTagRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreUpdateTagRequest $request, $id)
    {
        $this->tagRepo->updateTag($request->all(), $id);

        return redirect()->route('tags.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->tagRepo->delete($id);

        return redirect()->route('tags.index');
    }
}
