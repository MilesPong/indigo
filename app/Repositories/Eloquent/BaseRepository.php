<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Contracts\Repository as RepositoryInterface;
use App\Repositories\Eloquent\Traits\ApiResource;
use App\Repositories\Events\RepositoryEntityCreated;
use App\Repositories\Events\RepositoryEntityDeleted;
use App\Repositories\Events\RepositoryEntityUpdated;
use App\Repositories\Exceptions\RepositoryException;
use Closure;
use Illuminate\Container\Container;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Class BaseRepository
 * @package App\Repositories\Eloquent
 */
abstract class BaseRepository implements RepositoryInterface
{
    use ApiResource {
        ApiResource::parseResult as apiResourceParser;
    }

    /**
     * @var \Illuminate\Container\Container
     */
    protected $app;
    /**
     * @var \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    protected $model;
    /**
     * @var array
     */
    protected $relations = [];
    /**
     * @var \Closure
     */
    protected $scopeQuery;

    /**
     * BaseRepository constructor.
     * @param \Illuminate\Container\Container $app
     * @throws \App\Repositories\Exceptions\RepositoryException
     */
    public function __construct(Container $app)
    {
        $this->app = $app;
        $this->makeModel();

        $this->boot();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Model
     * @throws \App\Repositories\Exceptions\RepositoryException
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
     * @return string
     */
    abstract public function model();

    /**
     * The fake "booting" method of the model in calling scopes.
     */
    public function boot()
    {

    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|mixed
     */
    public function getModel()
    {
        if ($this->model instanceof Builder) {
            return $this->model->getModel();
        }

        return $this->model;
    }

    /**
     * @return string
     */
    public function getModelTable()
    {
        if ($this->model instanceof Builder) {
            return $this->model->getModel()->getTable();
        } else {
            return $this->model->getTable();
        }
    }

    /**
     * @param array $columns
     * @return mixed
     * @throws \App\Repositories\Exceptions\RepositoryException
     */
    public function all($columns = ['*'])
    {
        $this->applyScope();

        if ($this->model instanceof Builder) {
            $result = $this->model->get($columns);
        } else {
            $result = $this->model->all($columns);
        }

        // $this->resetModel();
        $this->resetScope();

        return $this->parseResult($result);
    }

    /**
     * @return $this
     */
    protected function applyScope()
    {
        if (isset($this->scopeQuery) && is_callable($this->scopeQuery)) {
            $callback = $this->scopeQuery;
            $this->model = $callback($this->model);
        }

        return $this;
    }

    /**
     * @return $this
     */
    public function resetScope()
    {
        $this->scopeQuery = null;

        return $this;
    }

    // /**
    //  * Reset the model after query
    //  */
    // protected function resetModel()
    // {
    //     try {
    //         $this->makeModel();
    //     } catch (RepositoryException $exception) {
    //         return false;
    //     }
    //
    //     return true;
    // }

    /**
     * @param $result
     * @return mixed
     * @throws \App\Repositories\Exceptions\RepositoryException
     */
    protected function parseResult($result)
    {
        return $this->apiResourceParser($result);
    }

    /**
     * @param null $perPage
     * @param array $columns
     * @return mixed
     * @throws \App\Repositories\Exceptions\RepositoryException
     */
    public function paginate($perPage = null, $columns = ['*'])
    {
        $this->applyScope();

        $result = $this->model->paginate($perPage ?: $this->getDefaultPerPage(), $columns);

        // $this->resetModel();
        $this->resetScope();

        return $this->parseResult($result);
    }

    /**
     * @return int
     */
    public function getDefaultPerPage()
    {
        return config('blog.repository.pagination.per_page');
    }


    /**
     * @param array $attributes
     * @return mixed
     * @throws \App\Repositories\Exceptions\RepositoryException
     */
    public function create(array $attributes)
    {
        $model = $this->model->create($attributes);

        event(new RepositoryEntityCreated($this, $model));

        return $this->parseResult($model);
    }


    /**
     * @param array $attributes
     * @param $id
     * @return mixed
     * @throws \App\Repositories\Exceptions\RepositoryException
     */
    public function update(array $attributes, $id)
    {
        $this->applyScope();

        $model = $this->model->findOrFail($id);
        $model->fill($attributes);
        $model->save();

        event(new RepositoryEntityUpdated($this, $model));

        // $this->resetModel();
        $this->resetScope();

        return $this->parseResult($model);
    }


    /**
     * @param $id
     * @return mixed
     * @throws \App\Repositories\Exceptions\RepositoryException
     */
    public function delete($id)
    {
        $this->applyScope();

        $model = $this->find($id);
        $originalModel = clone $model;

        $deleted = $model->delete();

        event(new RepositoryEntityDeleted($this, $originalModel));

        // $this->resetModel();
        $this->resetScope();

        return $deleted;
    }


    /**
     * @param $id
     * @param array $columns
     * @return mixed
     * @throws \App\Repositories\Exceptions\RepositoryException
     */
    public function find($id, $columns = ['*'])
    {
        $this->applyScope();

        $result = $this->model->findOrFail($id, $columns);

        // $this->resetModel();
        $this->resetScope();

        return $this->parseResult($result);
    }


    /**
     * @param $field
     * @param $value
     * @param array $columns
     * @return mixed
     * @throws \App\Repositories\Exceptions\RepositoryException
     */
    public function firstBy($field, $value, $columns = ['*'])
    {
        $this->applyScope();

        $result = $this->model->where($field, '=', $value)->first($columns);

        // $this->resetModel();
        $this->resetScope();

        return $this->parseResult($result);
    }


    /**
     * @param $field
     * @param $value
     * @param array $columns
     * @return mixed
     * @throws \App\Repositories\Exceptions\RepositoryException
     */
    public function allBy($field, $value, $columns = ['*'])
    {
        $this->applyScope();

        $result = $this->model->where($field, '=', $value)->get($columns);

        // $this->resetModel();
        $this->resetScope();

        return $this->parseResult($result);
    }


    /**
     * @param array $where
     * @param array $columns
     * @return mixed
     * @throws \App\Repositories\Exceptions\RepositoryException
     */
    public function getByWhere(array $where, $columns = ['*'])
    {
        $this->applyScope();

        $this->applyConditions($where);

        $result = $this->model->get($columns);

        // $this->resetModel();
        $this->resetScope();

        return $this->parseResult($result);
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

        $this->relations = is_string($relations) ? func_get_args() : $relations;

        return $this;
    }


    /**
     * @param array $attributes
     * @return mixed
     * @throws \App\Repositories\Exceptions\RepositoryException
     */
    public function firstOrCreate(array $attributes = [])
    {
        $this->applyScope();

        $result = $this->model->firstOrCreate($attributes);

        // $this->resetModel();
        $this->resetScope();

        return $this->parseResult($result);
    }


    /**
     * @return \App\Repositories\Eloquent\BaseRepository|mixed
     */
    public function onlyTrashed()
    {
        return $this->trashed(true);
    }

    /**
     * @param bool $only
     * @return $this
     */
    protected function trashed($only = false)
    {
        if ($only) {
            $this->model = $this->model->onlyTrashed();
        } else {
            $this->model = $this->model->withTrashed();
        }

        return $this;
    }


    /**
     * @param $id
     * @return mixed
     * @throws \App\Repositories\Exceptions\RepositoryException
     */
    public function restore($id)
    {
        $this->applyScope();

        $result = $this->withTrashed()->find($id)->restore();

        // $this->resetModel();
        $this->resetScope();

        return $result;
    }

    /**
     * @return \App\Repositories\Eloquent\BaseRepository|mixed
     */
    public function withTrashed()
    {
        return $this->trashed();
    }

    /**
     * @param $id
     * @return mixed
     * @throws \App\Repositories\Exceptions\RepositoryException
     */
    public function forceDelete($id)
    {
        $this->applyScope();

        $result = $this->withTrashed()->find($id)->forceDelete();

        // $this->resetModel();
        $this->resetScope();

        return $result;
    }

    /**
     * @param mixed $relations
     * @return $this
     */
    public function withCount($relations)
    {
        $this->model = $this->model->withCount($relations);

        $this->relations = is_string($relations) ? func_get_args() : $relations;

        return $this;
    }

    /**
     * @param $relation
     * @return $this
     */
    public function has($relation)
    {
        $this->model = $this->model->has($relation);

        return $this;
    }

    /**
     * @param $relation
     * @param \Closure|null $callback
     * @return $this
     */
    public function whereHas($relation, Closure $callback = null)
    {
        $this->model = $this->model->whereHas($relation, $callback);

        return $this;
    }

    /**
     * @param $column
     * @param string $direction
     * @return $this
     */
    public function orderBy($column, $direction = 'asc')
    {
        $this->model = $this->model->orderBy($column, $direction);

        return $this;
    }

    /**
     * @param \Closure $callback
     * @return $this
     */
    public function scopeQuery(Closure $callback)
    {
        $this->scopeQuery = $callback;

        return $this;
    }


    /**
     * @param array $columns
     * @return mixed
     * @throws \App\Repositories\Exceptions\RepositoryException
     */
    public function first($columns = ['*'])
    {
        $this->applyScope();

        $result = $this->model->firstOrFail($columns);

        // $this->resetModel();
        $this->resetScope();

        return $this->parseResult($result);
    }
}
