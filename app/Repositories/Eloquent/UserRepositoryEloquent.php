<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Repositories\Contracts\UserRepository;
use Illuminate\Database\Eloquent\Model;
use App\Http\Resources\User as UserResource;

/**
 * Class UserRepositoryEloquent
 * @package App\Repositories\Eloquent
 */
class UserRepositoryEloquent extends BaseRepository implements UserRepository
{
    /**
     * @return string
     */
    public function model()
    {
        return User::class;
    }

    /**
     * @return null|string
     */
    public function resource()
    {
        return UserResource::class;
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

        $this->syncRoles($model, array_get($attributes, 'role'));

        return $this->parseResult($model);
    }

    /**
     * @param $model
     * @param $roleIds
     * @return mixed|null
     */
    protected function syncRoles($model, $roleIds)
    {
        $roles = call_user_func([$model, 'roles']);

        return call_user_func_array([$roles, 'sync'], [$roleIds]);
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

        $this->syncRoles($model, array_get($attributes, 'role'));

        return $this->parseResult($model);
    }
}
