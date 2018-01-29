<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\StoreUpdateCategoryRequest;
use App\Repositories\Contracts\CategoryRepository;

/**
 * Class CategoryController
 * @package App\Http\Controllers\Backend
 */
class CategoryController extends BackendController
{
    /**
     * @var CategoryRepository
     */
    protected $categoryRepository;

    /**
     * CategoryController constructor.
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = $this->categoryRepository->paginate();

        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreUpdateCategoryRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreUpdateCategoryRequest $request)
    {
        $category = $this->categoryRepository->create($request->all());

        return $this->successCreated($category);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = $this->categoryRepository->find($id);

        return response($category);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = $this->categoryRepository->find($id);

        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  StoreUpdateCategoryRequest $request
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(StoreUpdateCategoryRequest $request, $id)
    {
        $category = $this->categoryRepository->update($request->all(), $id);

        return $this->successCreated($category);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $this->categoryRepository->delete($id);

        return $this->successDeleted();
    }
}
