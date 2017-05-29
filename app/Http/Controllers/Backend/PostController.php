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
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
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

        return redirect()->route('posts.index');
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
        $post = $this->postRepo->find($id);

        $categories = $this->cateRepo->all();
        $tags = $this->tagRepo->all();

        $selected_tags = $this->postRepo->getTags($post);

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

        return redirect()->route('posts.index');
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

        return redirect()->route('posts.index');
    }
}
