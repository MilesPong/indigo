<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\StoreUpdatePostRequest;
use App\Repositories\Contracts\CategoryRepository;
use App\Repositories\Contracts\PostRepository;
use App\Repositories\Contracts\TagRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Class PostController
 * @package App\Http\Controllers\Backend
 */
class PostController extends Controller
{
    /**
     * @var PostRepository
     */
    protected $postRepository;
    /**
     * @var CategoryRepository
     */
    protected $categoryRepository;
    /**
     * @var TagRepository
     */
    protected $tagRepository;

    /**
     * PostController constructor.
     * @param PostRepository $postRepository
     * @param CategoryRepository $categoryRepository
     * @param TagRepository $tagRepository
     */
    public function __construct(PostRepository $postRepository, CategoryRepository $categoryRepository, TagRepository $tagRepository)
    {
        $this->postRepository = $postRepository;
        $this->categoryRepository = $categoryRepository;
        $this->tagRepository = $tagRepository;
    }

    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->has('trash')) {
            $this->postRepository = $this->postRepository->onlyTrashed();
        }

        $posts = $this->postRepository->with(['category', 'author'])->paginate();

        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = $this->categoryRepository->all();
        $tags = $this->tagRepository->all();

        return view('admin.posts.create', compact('categories', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreUpdatePostRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUpdatePostRequest $request)
    {
        $this->postRepository->createPost($request->except('_token'));

        return redirect()->route('admin.posts.index')->withSuccess('Create post successfully!');
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

        $categories = $this->categoryRepository->all();
        $tags = $this->tagRepository->all();

        return view('admin.posts.edit', compact('post', 'categories', 'tags', 'selected_tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  StoreUpdatePostRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreUpdatePostRequest $request, $id)
    {
        $this->postRepository->updatePost($request->all(), $id);

        return redirect()->route('admin.posts.index')->withSuccess('Update post successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->postRepository->delete($id);

        return redirect()->route('admin.posts.index')->withSuccess('Move post to trash successfully!');
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore($id)
    {
        $this->postRepository->restore($id);

        return redirect()->route('admin.posts.index')->withSuccess('Restore post successfully!');
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function forceDelete($id)
    {
        $this->postRepository->forceDelete($id);

        return redirect()->back()->withSuccess('Force delete post successfully!');
    }
}
