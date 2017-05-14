<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\StoreUpdateRoleRequest;
use App\Repositories\Contracts\PermissionRepository;
use App\Repositories\Contracts\RoleRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RoleController extends Controller
{
    /**
     * @var RoleRepository
     */
    protected $roleRepo;

    /**
     * @var PermissionRepository
     */
    protected $permRepo;

    /**
     * RoleController constructor.
     * @param RoleRepository $roleRepo
     * @param PermissionRepository $permRepo
     */
    public function __construct(RoleRepository $roleRepo, PermissionRepository $permRepo)
    {
        $this->roleRepo = $roleRepo;
        $this->permRepo = $permRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = $this->roleRepo->paginate(10);

        return view('admin.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions = $this->permRepo->all();

        return view('admin.roles.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreUpdateRoleRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUpdateRoleRequest $request)
    {
        $role = $this->roleRepo->createRole($request->all());

        return redirect()->route('roles.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $role = $this->roleRepo->find($id);

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
        $role = $this->roleRepo->find($id);

        $permissions = $this->permRepo->all();

        $selected_perms = $this->roleRepo->getPermissionIds($role);

        return view('admin.roles.edit', compact('role', 'permissions', 'selected_perms'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  StoreUpdateRoleRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreUpdateRoleRequest $request, $id)
    {
        $role = $this->roleRepo->updateRole($request->all(), $id);

        return redirect()->route('roles.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->roleRepo->delete($id);

        return redirect()->route('roles.index');
    }
}
