<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdatePermissionRequest;
use App\Repositories\Contracts\PermissionRepository;

/**
 * Class PermissionController
 * @package App\Http\Controllers\Backend
 */
class PermissionController extends Controller
{
    /**
     * @var PermissionRepository
     */
    protected $permissionRepository;

    /**
     * PermissionController constructor.
     * @param \App\Repositories\Contracts\PermissionRepository $permissionRepository
     */
    public function __construct(PermissionRepository $permissionRepository)
    {
        $this->permissionRepository = $permissionRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $permissions = $this->permissionRepository->paginate(10);

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
        $permission = $this->permissionRepository->create($request->all());

        return redirect()->route('admin.permissions.index')->withSuccess('Create permission successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $perm = $this->permissionRepository->find($id);

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
        $permission = $this->permissionRepository->find($id);

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
        $permission = $this->permissionRepository->update($request->all(), $id);

        return redirect()->route('admin.permissions.index')->withSuccess('Update permission successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->permissionRepository->delete($id);

        return redirect()->route('admin.permissions.index')->withSuccess('Delete permission successfully!');
    }
}
