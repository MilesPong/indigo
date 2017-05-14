<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\StoreUpdatePermissionRequest;
use App\Repositories\Contracts\PermissionRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PermissionController extends Controller
{
    protected $permRepo;

    /**
     * PermissionController constructor.
     * @param \App\Repositories\Contracts\PermissionRepository $permRepo
     */
    public function __construct(PermissionRepository $permRepo)
    {
        $this->permRepo = $permRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $permissions = $this->permRepo->paginate();

        return view('admin.permissions.index', compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.permissions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreUpdatePermissionRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUpdatePermissionRequest $request)
    {
        $perm = $this->permRepo->create($request->all());

        return redirect()->route('permissions.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $perm = $this->permRepo->find($id);

        return response($perm);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $permission = $this->permRepo->find($id);

        return view('admin.permissions.edit', compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  StoreUpdatePermissionRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreUpdatePermissionRequest $request, $id)
    {
        $perm = $this->permRepo->update($request->all(), $id);

        return redirect()->route('permissions.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->permRepo->delete($id);

        return redirect()->route('permissions.index');
    }
}
