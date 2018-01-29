<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\StoreUpdateRoleRequest;
use App\Repositories\Contracts\PermissionRepository;
use App\Repositories\Contracts\RoleRepository;

class RoleController extends BackendController
{
    /**
     * @var RoleRepository
     */
    protected $roleRepository;

    /**
     * @var PermissionRepository
     */
    protected $permissionRepository;

    /**
     * RoleController constructor.
     * @param RoleRepository $roleRepository
     * @param PermissionRepository $permissionRepository
     */
    public function __construct(RoleRepository $roleRepository, PermissionRepository $permissionRepository)
    {
        $this->roleRepository = $roleRepository;
        $this->permissionRepository = $permissionRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = $this->roleRepository->paginate(10);

        return view('admin.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.roles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreUpdateRoleRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreUpdateRoleRequest $request)
    {
        $role = $this->roleRepository->create($request->all());

        return $this->successCreated($role);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $role = $this->roleRepository->find($id);

        return response($role);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = $this->roleRepository->with('perms')->find($id);

        return view('admin.roles.edit', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  StoreUpdateRoleRequest $request
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(StoreUpdateRoleRequest $request, $id)
    {
        $role = $this->roleRepository->update($request->all(), $id);

        return $this->successCreated($role);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $this->roleRepository->delete($id);

        return $this->successDeleted();
    }
}
