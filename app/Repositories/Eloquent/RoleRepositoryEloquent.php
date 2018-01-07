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
        $model = $this->tempDisableApiResource(function () use ($attributes) {
            return parent::create($attributes);
        });

        $this->syncPermissions($model, array_get($attributes, 'permission'));

        return $this->parseResult($model);
    }

    /**
     * Sync role's permissions
     *
     * @param $model
     * @param $permissionIds
     * @return mixed|null
     */
    protected function syncPermissions($model, $permissionIds)
    {
        return $model->perms()->sync($permissionIds);
    }

    /**
     * @param array $attributes
     * @param $id
     * @return mixed|null
     * @throws \App\Repositories\Exceptions\RepositoryException
     */
    public function update(array $attributes, $id)
    {
        $model = $this->tempDisableApiResource(function () use ($attributes, $id) {
            return parent::update($attributes, $id);
        });

        $this->syncPermissions($model, array_get($attributes, 'permission'));

        return $this->parseResult($model);
    }
}