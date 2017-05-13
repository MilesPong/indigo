<?php

namespace App\Repositories\Eloquent;

use App\Models\Role;

/**
 * Class RoleRepository
 * @package App\Repositories\Eloquent
 */
class RoleRepository extends Repository
{
    /**
     * @return string
     */
    public function model()
    {
        return Role::class;
    }
}