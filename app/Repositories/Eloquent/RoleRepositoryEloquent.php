<?php

namespace App\Repositories\Eloquent;

use App\Http\Resources\Role as RoleResource;
use App\Models\Role;
use App\Repositories\Contracts\RoleRepository;

/**
 * Class RoleRepositoryEloquent
 * @package App\Repositories\Eloquent
 */
class RoleRepositoryEloquent extends BaseRepository implements RoleRepository
{
    /**
     * @return string
     */
    public function model()
    {
        return Role::class;
    }

    /**
     * @return null|string
     */
    public function resource()
    {
        return RoleResource::class;
    }

    /**
     * @param array $attributes
     * @return mixed|null
     * @throws \App\Repositories\Exceptions\RepositoryException
     */
    public function create(array $attributes)
    {
        $this->model = parent::create($attributes);

        return $this->syncPermissions(array_get($attributes, 'permission'));
    }

    /**
     * Sync role's permissions
     *
     * @param $permissionIds
     * @return mixed|null
     */
    protected function syncPermissions($permissionIds)
    {
        if (!$this->model->exists) {
            return null;
        }

        $permission = call_user_func([$this->model, 'perms']);

        return call_user_func_array([$permission, 'sync'], [$permissionIds]);
    }

    /**
     * @param array $attributes
     * @param $id
     * @return mixed|null
     * @throws \App\Repositories\Exceptions\RepositoryException
     */
    public function update(array $attributes, $id)
    {
        $this->model = parent::update($attributes, $id);

        return $this->syncPermissions(array_get($attributes, 'permission'));
    }
}