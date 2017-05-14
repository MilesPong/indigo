<?php

namespace App\Repositories\Contracts;

/**
 * Interface UserRepository
 * @package App\Repositories\Contracts
 */
/**
 * Interface UserRepository
 * @package App\Repositories\Contracts
 */
interface UserRepository extends RepositoryInterface
{
    /**
     * Create User
     *
     * @param array $attributes
     * @return mixed
     */
    public function createUser(array $attributes);

    /**
     * Update User
     *
     * @param array $attributes
     * @param $id
     * @return mixed
     */
    public function updateUser(array $attributes, $id);

    /**
     * Get user's role ids
     *
     * @param $id
     * @param bool $toArray
     * @return mixed
     */
    public function getRoleIds($id, $toArray = true);
}
