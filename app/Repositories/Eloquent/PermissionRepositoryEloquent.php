<?php

namespace App\Repositories\Eloquent;

use App\Models\Permission;
use App\Repositories\Contracts\PermissionRepository;

/**
 * Class PermissionRepositoryEloquent
 * @package App\Repositories\Eloquent
 */
class PermissionRepositoryEloquent extends Repository implements PermissionRepository
{
    /**
     * @return string
     */
    public function model()
    {
        return Permission::class;
    }
}