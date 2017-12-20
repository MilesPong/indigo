<?php

namespace App\Repositories\Eloquent;

use App\Models\Role;
use App\Repositories\Contracts\RoleRepository;
use Illuminate\Database\Eloquent\Model;
use App\Http\Resources\Role as RoleResource;

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
     * Create role
     *
     * @param array $attributes
     * @return mixed|null
     */
    public function createRole(array $attributes)
    {
        $this->model = $this->create($attributes);

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
     * Update Role
     *
     * @param array $attributes
     * @param $id
     * @return mixed|null
     */
    public function updateRole(array $attributes, $id)
    {
        $this->model = $this->update($attributes, $id);

        return $this->syncPermissions(array_get($attributes, 'permission'));
    }

    /**
     * Get role's permissions ids
     *
     * @param $value
     * @param bool $toArray
     * @return mixed
     */
    public function getPermissionIds($value, $toArray = true)
    {
        if ($value instanceof Model) {
            $this->model = $value;
        } else {
            $this->model = $this->find($value);
        }

        $permIds = $this->model->perms()->get()->pluck('pivot.permission_id');

        if ($toArray) {
            return $permIds->toArray();
        }

        return $permIds;
    }
}