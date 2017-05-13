<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\StoreUpdateRoleRequest;
use App\Repositories\Eloquent\RoleRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RoleController extends Controller
{
    /**
     * @var RoleRepository
     */
    protected $roleRepo;

    /**
     * RoleController constructor.
     * @param RoleRepository $roleRepo
     */
    public function __construct(RoleRepository $roleRepo)
    {
        $this->roleRepo = $roleRepo;
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
        return view('admin.roles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreUpdateRoleRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUpdateRoleRequest $request)
    {
        $role = $this->roleRepo->create($request->all());

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

        return view('admin.roles.edit', compact('role'));
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
        $role = $this->roleRepo->update($request->all(), $id);

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
