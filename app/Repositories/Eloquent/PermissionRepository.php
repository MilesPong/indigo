<?php

namespace App\Repositories\Eloquent;

use App\Models\Permission;

/**
 * Class PermissionRepository
 * @package App\Repositories\Eloquent
 */
class PermissionRepository extends Repository
{
    /**
     * @return string
     */
    public function model()
    {
        return Permission::class;
    }
}