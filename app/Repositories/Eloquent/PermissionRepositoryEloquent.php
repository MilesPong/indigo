<?php

namespace App\Repositories\Eloquent;

use App\Models\Permission;
use App\Repositories\Contracts\PermissionRepository;
use App\Http\Resources\Permission as PermissionResource;

/**
 * Class PermissionRepositoryEloquent
 * @package App\Repositories\Eloquent
 */
class PermissionRepositoryEloquent extends BaseRepository implements PermissionRepository
{
    /**
     * @return string
     */
    public function model()
    {
        return Permission::class;
    }

    /**
     * @return null|string
     */
    public function resource()
    {
        return PermissionResource::class;
    }
}