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
        $this->model = parent::create($attributes);

        return $this->syncRoles(array_get($attributes, 'role'));
    }

    /**
     * @param $roleIds
     * @return mixed|null
     */
    protected function syncRoles($roleIds)
    {
        if (!$this->model->exists) {
            return null;
        }

        $roles = call_user_func([$this->model, 'roles']);

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
        $this->model = parent::update($attributes, $id);

        return $this->syncRoles(array_get($attributes, 'role'));
    }
}
