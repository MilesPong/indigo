<?php

namespace App\Repositories\Eloquent;

use App\Models\Role;
use App\Repositories\Contracts\RoleRepository;

/**
 * Class RoleRepositoryEloquent
 * @package App\Repositories\Eloquent
 */
class RoleRepositoryEloquent extends Repository implements RoleRepository
{
    /**
     * @return string
     */
    public function model()
    {
        return Role::class;
    }
}