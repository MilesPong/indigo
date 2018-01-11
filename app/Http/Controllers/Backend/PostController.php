<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\StoreUpdatePostRequest;
use App\Repositories\Contracts\CategoryRepository;
use App\Repositories\Contracts\PostRepository;
use App\Repositories\Contracts\TagRepository;
use Illuminate\Http\Request;

/**
 * Class PostController
 * @package App\Http\Controllers\Backend
 */
class PostController extends BackendController
{
    /**
     * @var \App\Repositories\Contracts\PostRepository
     */
    protected $postRepository;
    /**
     * @var \App\Repositories\Contracts\CategoryRepository
     */
    protected $categoryRepository;
    /**
     * @var \App\Repositories\Contracts\TagRepository
     */
    protected $tagRepository;

    /**
     * PostController constructor.
     * @param \App\Repositories\Contracts\PostRepository $postRepository
     * @param \App\Repositories\Contracts\CategoryRepository $categoryRepository
     * @param \App\Repositories\Contracts\TagRepository $tagRepository
     */
    public function __construct(
        PostRepository $postRepository,
        CategoryRepository $categoryRepository,
        TagRepository $tagRepository
    ) {
        $this->postRepository = $postRepository;
        $this->categoryRepository = $categoryRepository;
        $this->tagRepository = $tagRepository;
    }

    /**
     * Display a listing of the resource.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->has('trash')) {
            $this->postRepository->onlyTrashed();
        }

        $posts = $this->postRepository
            ->with(['category', 'author'])
            ->orderBy('id', 'desc')
            ->paginate();

        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreUpdatePostRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreUpdatePostRequest $request)
    {
        $post = $this->postRepository->create($request->all());

        return $this->successCreated($post);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = $this->postRepository->find($id);

        return response($post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = $this->postRepository->with('tags')->find($id);

        return view('admin.posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\StoreUpdatePostRequest $request
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(StoreUpdatePostRequest $request, $id)
    {
        $post = $this->postRepository->update($request->all(), $id);

        return $this->successCreated($post);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $this->postRepository->delete($id);

        return $this->successDeleted();
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function restore($id)
    {
        $this->postRepository->restore($id);

        return $this->successNoContent();
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function forceDelete($id)
    {
        $this->postRepository->forceDelete($id);

        return $this->successDeleted();
    }
}
