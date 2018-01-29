<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\StoreUpdateTagRequest;
use App\Repositories\Contracts\TagRepository;

class TagController extends BackendController
{
    protected $tagRepository;

    /**
     * TagController constructor.
     * @param TagRepository $tagRepository
     */
    public function __construct(TagRepository $tagRepository)
    {
        $this->tagRepository = $tagRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tags = $this->tagRepository->paginate();

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
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreUpdateTagRequest $request)
    {
        $tag = $this->tagRepository->create($request->all());

        return $this->successCreated($tag);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tag = $this->tagRepository->find($id);

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
        $tag = $this->tagRepository->find($id);

        return view('admin.tags.edit', compact('tag'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  StoreUpdateTagRequest $request
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(StoreUpdateTagRequest $request, $id)
    {
        $tag = $this->tagRepository->update($request->all(), $id);

        return $this->successCreated($tag);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $this->tagRepository->delete($id);

        return $this->successDeleted();
    }
}
