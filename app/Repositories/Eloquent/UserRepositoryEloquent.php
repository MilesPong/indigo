<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Repositories\Contracts\UserRepository;
use Illuminate\Database\Eloquent\Model;

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
     * Create User
     *
     * @param array $attributes
     * @return mixed|null
     */
    public function createUser(array $attributes)
    {
        $this->model = $this->create($attributes);

        return $this->syncRoles(array_get($attributes, 'role'));
    }

    /**
     * Sync user's roles
     *
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
     * Update User
     *
     * @param array $attributes
     * @param $id
     * @return mixed|null
     */
    public function updateUser(array $attributes, $id)
    {
        $this->model = $this->update($attributes, $id);

        return $this->syncRoles(array_get($attributes, 'role'));
    }

    /**
     * Get user's role ids
     *
     * @param $id
     * @param bool $toArray
     * @return mixed
     */
    public function getRoleIds($id, $toArray = true)
    {
        if ($id instanceof Model) {
            $this->model = $id;
        } else {
            $this->model = $this->find($id);
        }

        $roleIds = $this->model->roles()->get()->pluck('pivot.role_id');

        if ($toArray) {
            return $roleIds->toArray();
        }

        return $roleIds;
    }
}
