<?php

namespace App\Repositories\Contracts;

/**
 * Interface RoleRepository
 * @package App\Repositories\Contracts
 */
interface RoleRepository extends RepositoryInterface
{
    /**
     * Create role
     *
     * @param array $attributes
     * @return mixed
     */
    public function createRole(array $attributes);

    /**
     * Update Role
     *
     * @param array $attributes
     * @param $id
     * @return mixed
     */
    public function updateRole(array $attributes, $id);
}
