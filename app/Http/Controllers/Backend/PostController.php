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
    protected $postRepo;
    /**
     * @var CategoryRepository
     */
    protected $cateRepo;
    /**
     * @var TagRepository
     */
    protected $tagRepo;

    /**
     * PostController constructor.
     * @param PostRepository $postRepo
     * @param CategoryRepository $cateRepo
     * @param TagRepository $tagRepo
     */
    public function __construct(PostRepository $postRepo, CategoryRepository $cateRepo, TagRepository $tagRepo)
    {
        $this->postRepo = $postRepo;
        $this->cateRepo = $cateRepo;
        $this->tagRepo = $tagRepo;
    }

    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->has('trash')) {
            $this->postRepo = $this->postRepo->onlyTrashed();
        }

        $posts = $this->postRepo->with(['category', 'author'])->paginate();

        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = $this->cateRepo->all();
        $tags = $this->tagRepo->all();

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
        $this->postRepo->createPost($request->all());

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
        $post = $this->postRepo->find($id);

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
        $post = $this->postRepo->with('tags')->find($id);

        $categories = $this->cateRepo->all();
        $tags = $this->tagRepo->all();

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
        $this->postRepo->updatePost($request->all(), $id);

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
        $this->postRepo->delete($id);

        return redirect()->route('admin.posts.index')->withSuccess('Move post to trash successfully!');
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore($id)
    {
        $this->postRepo->restore($id);

        return redirect()->route('admin.posts.index')->withSuccess('Restore post successfully!');
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function forceDelete($id)
    {
        $this->postRepo->forceDelete($id);

        return redirect()->back()->withSuccess('Force delete post successfully!');
    }
}
