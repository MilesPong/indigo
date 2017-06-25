<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Contracts\RepositoryInterface;
use App\Repositories\Exceptions\RepositoryException;
use Illuminate\Container\Container;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Class BaseRepository
 * @package App\Repositories\Eloquent
 */
abstract class BaseRepository implements RepositoryInterface
{
    /**
     * @var Container
     */
    protected $app;

    /**
     * @var Model|Builder
     */
    protected $model;

    /**
     * BaseRepository constructor.
     * @param Container $app
     */
    public function __construct(Container $app)
    {
        $this->app = $app;
        $this->makeModel();
    }

    /**
     * @return Model|mixed
     * @throws RepositoryException
     */
    public function makeModel()
    {
        $model = $this->app->make($this->model());

        if (!$model instanceof Model) {
            throw new RepositoryException("Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model");
        }

        return $this->model = $model;
    }

    /**
     * @return mixed
     */
    abstract public function model();

    /**
     * @return Builder|Model
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * The fake "booting" method of the model in calling scopes.
     */
    public function scopeBoot()
    {

    }

    /**
     * @param array $columns
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function all($columns = ['*'])
    {
        $this->scopeBoot();

        if ($this->model instanceof Builder) {
            $results = $this->model->get($columns);
        } else {
            $results = $this->model->all($columns);
        }

        return $results;
    }

    /**
     * @param int $perPage
     * @param array $columns
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginate($perPage = 10, $columns = ['*'])
    {
        $this->scopeBoot();

        return $this->model->paginate($perPage, $columns);
    }

    /**
     * @param array $attributes
     * @return Model
     */
    public function create(array $attributes)
    {
        return $this->model->create($attributes);
    }

    /**
     * @param array $attributes
     * @param $id
     * @return \Illuminate\Database\Eloquent\Collection|Model
     */
    public function update(array $attributes, $id)
    {
        $this->scopeBoot();

        $model = $this->model->findOrFail($id);
        $model->fill($attributes);
        $model->save();

        return $model;
    }

    /**
     * @param $id
     * @return int
     */
    public function delete($id)
    {
        $this->scopeBoot();

        return $this->find($id)->delete();
    }

    /**
     * @param $id
     * @param array $columns
     * @return \Illuminate\Database\Eloquent\Collection|Model
     */
    public function find($id, $columns = ['*'])
    {
        $this->scopeBoot();

        return $this->model->findOrFail($id, $columns);
    }

    /**
     * @param $field
     * @param $value
     * @param array $columns
     * @return mixed
     */
    public function findBy($field, $value, $columns = ['*'])
    {
        $this->scopeBoot();

        return $this->model->where($field, '=', $value)->first($columns);
    }

    /**
     * @param $field
     * @param $value
     * @param array $columns
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function findAllBy($field, $value, $columns = ['*'])
    {
        $this->scopeBoot();

        return $this->model->where($field, '=', $value)->get($columns);
    }

    /**
     * @param array $where
     * @param array $columns
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function findWhere(array $where, $columns = ['*'])
    {
        $this->scopeBoot();

        $this->applyConditions($where);

        return $this->model->get($columns);
    }

    /**
     * Applies the given where conditions to the model.
     *
     * @param array $where
     * @return void
     */
    protected function applyConditions(array $where)
    {
        foreach ($where as $field => $value) {
            if (is_array($value)) {
                list($field, $condition, $val) = $value;
                $this->model = $this->model->where($field, $condition, $val);
            } else {
                $this->model = $this->model->where($field, '=', $value);
            }
        }
    }

    /**
     * Load relations
     *
     * @param array|string $relations
     *
     * @return $this
     */
    public function with($relations)
    {
        $this->model = $this->model->with($relations);
        return $this;
    }

    /**
     * @param array $attributes
     * @return Model
     */
    public function firstOrCreate(array $attributes = [])
    {
        $this->scopeBoot();

        return $this->model->firstOrCreate($attributes);
    }

    /**
     * @param bool $only
     * @return $this
     */
    public function trashed($only = false)
    {
        $this->scopeBoot();

        if ($only) {
            $this->model = $this->model->onlyTrashed();
        } else {
            $this->model = $this->model->withTrashed();
        }

        return $this;
    }

    /**
     * @return BaseRepository
     */
    public function onlyTrashed()
    {
        return $this->trashed(true);
    }

    /**
     * @return BaseRepository
     */
    public function withTrashed()
    {
        return $this->trashed();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function restore($id)
    {
        $this->scopeBoot();

        return $this->withTrashed()->find($id)->restore();
    }

    /**
     * @param $id
     * @return bool|null
     */
    public function forceDelete($id)
    {
        $this->scopeBoot();

        return $this->withTrashed()->find($id)->forceDelete();
    }

    /**
     * @param mixed $relations
     * @return $this
     */
    public function withCount($relations)
    {
        $this->model = $this->model->withCount($relations);

        return $this;
    }
}