<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Contracts\Repository as RepositoryInterface;
use App\Repositories\Eloquent\Traits\ApiResource;
use App\Repositories\Eloquent\Traits\HasCriteria;
use App\Repositories\Events\RepositoryEntityCreated;
use App\Repositories\Events\RepositoryEntityDeleted;
use App\Repositories\Events\RepositoryEntityUpdated;
use App\Repositories\Exceptions\RepositoryException;
use Closure;
use Illuminate\Container\Container;
use Illuminate\Database\Eloquent\Model;

/**
 * Class BaseRepository
 * @package App\Repositories\Eloquent
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
abstract class BaseRepository implements RepositoryInterface
{
    use HasCriteria, ApiResource {
        ApiResource::parseResult as apiResourceParser;
    }
    /**
     * @var \Illuminate\Container\Container
     */
    protected $app;
    /**
     * @var \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Builder
     */
    protected $model;
    /**
     * @var array
     */
    protected $with = [];
    /**
     * @var array
     */
    protected $withCount = [];
    /**
     * @var \Closure
     */
    protected $scopeQuery;
    /**
     * @var array
     */
    protected $where = [];
    /**
     * @var
     */
    protected $limit;
    /**
     * @var
     */
    protected $offset;
    /**
     * @var array
     */
    protected $orderBy = [];

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
     * @return \Illuminate\Database\Eloquent\Model|mixed
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
     * @param $method
     * @param $parameters
     * @return string
     */
    public static function __callStatic($method, $parameters)
    {
        $class = static::class;

        forward_static_call_array([$class, $method], $parameters);

        return $class;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|mixed
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @param array $columns
     * @return mixed
     * @throws \App\Repositories\Exceptions\RepositoryException
     */
    public function findAll($columns = ['*'])
    {
        return $this->runQuery(function () use ($columns) {
            return $this->model->get($columns);
        });
    }

    /**
     * @param $callback
     * @return mixed
     * @throws \App\Repositories\Exceptions\RepositoryException
     */
    protected function runQuery($callback)
    {
        $this->prepareQuery();

        if (method_exists($this, $method = 'applyCriteria')) {
            call_user_func([$this, $method]);
        }

        $this->applyScope();

        $result = $callback();

        $this->resetRepository();

        return $this->parseResult($result);
    }

    /**
     * @return $this
     */
    protected function prepareQuery()
    {
        if (!empty($this->with)) {
            $this->model->with($this->with);
        }

        $this->model->withCount($this->withCount);

        foreach ($this->where as $where) {
            $this->model->where(...$where);
        }

        foreach ($this->orderBy as $orderBy) {
            $this->model->orderBy(...$orderBy);
        }

        if ($this->offset > 0) {
            $this->model->offset($this->offset);
        }

        if ($this->limit > 0) {
            $this->model->limit($this->limit);
        }

        return $this;
    }

    /**
     * @return $this
     */
    protected function applyScope()
    {
        if (isset($this->scopeQuery) && is_callable($this->scopeQuery)) {
            call_user_func($this->scopeQuery, $this->model);
        }

        return $this;
    }

    /**
     * @return $this
     * @throws \App\Repositories\Exceptions\RepositoryException
     */
    protected function resetRepository()
    {
        $this->with = [];
        $this->where = [];
        $this->orderBy = [];
        $this->offset = null;
        $this->limit = null;

        $this->resetScope();

        $this->makeModel();

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
        return $this->runQuery(function () use ($perPage, $columns) {
            return $this->model->paginate($perPage ?: $this->getDefaultPerPage(), $columns);
        });
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
        return $this->runQuery(function () use ($attributes, $id) {
            $model = $this->model->findOrFail($id);

            $model->fill($attributes);
            $model->save();

            event(new RepositoryEntityUpdated($this, $model));

            return $model;
        });
    }

    /**
     * @param $id
     * @return mixed
     * @throws \App\Repositories\Exceptions\RepositoryException
     */
    public function delete($id)
    {
        return $this->useResource(false)
            ->runQuery(function () use ($id) {
                $model = $this->find($id);
                $originalModel = clone $model;

                $deleted = $model->delete();

                event(new RepositoryEntityDeleted($this, $originalModel));

                return $deleted;
            });
    }

    /**
     * @param $id
     * @param array $columns
     * @return mixed
     * @throws \App\Repositories\Exceptions\RepositoryException
     */
    public function find($id, $columns = ['*'])
    {
        return $this->runQuery(function () use ($id, $columns) {
            return $this->model->findOrFail($id, $columns);
        });
    }

    /**
     * @param $field
     * @param $value
     * @param array $columns
     * @return mixed
     * @throws \App\Repositories\Exceptions\RepositoryException
     */
    public function findBy($field, $value, $columns = ['*'])
    {
        return $this->runQuery(function () use ($field, $value, $columns) {
            return $this->model->where($field, $value)->firstOrFail($columns);
        });
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
        $this->with = $relations;

        return $this;
    }

    /**
     * @param mixed $relations
     * @return $this
     */
    public function withCount($relations)
    {
        $this->withCount = $relations;

        return $this;
    }

    /**
     * @param array $attributes
     * @return mixed
     * @throws \App\Repositories\Exceptions\RepositoryException
     */
    public function firstOrCreate(array $attributes = [])
    {
        return $this->runQuery(function () use ($attributes) {
            return $this->model->firstOrCreate($attributes);
        });
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
        $only ? $this->model->onlyTrashed() : $this->model->withTrashed();

        return $this;
    }

    /**
     * @param $id
     * @return mixed
     * @throws \App\Repositories\Exceptions\RepositoryException
     */
    public function restore($id)
    {
        $this->withTrashed();

        return $this->runQuery(function () use ($id) {
            return $this->model->findOrFail($id)->restore();
        });
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
        $this->withTrashed();

        return $this->runQuery(function () use ($id) {
            return $this->model->findOrFail($id)->forceDelete();
        });
    }

    /**
     * @param $method
     * @param $parameters
     * @return $this
     */
    public function __call($method, $parameters)
    {
        $this->model->{$method}(...$parameters);

        return $this;
    }

    /**
     * @param $column
     * @param string $direction
     * @return $this
     */
    public function orderBy($column, $direction = 'asc')
    {
        array_push($this->orderBy, [$column, $direction]);

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
        return $this->runQuery(function () use ($columns) {
            return $this->model->first($columns);
        });
    }

    /**
     * @param $limit
     * @return $this
     */
    public function limit($limit)
    {
        $this->limit = $limit;

        return $this;
    }

    /**
     * @param $offset
     * @return $this
     */
    public function offset($offset)
    {
        $this->offset = $offset;

        return $this;
    }

    /**
     * @param array|\Closure|string $column
     * @param null $operator
     * @param null $value
     * @param string $boolean
     * @return $this
     */
    public function where($column, $operator = null, $value = null, $boolean = 'and')
    {
        array_push($this->where, func_get_args());

        return $this;
    }

    /**
     * @param array $attributes
     * @return \Illuminate\Database\Eloquent\Model|static
     */
    protected function getModelNewInstance($attributes = [])
    {
        return $this->model instanceof Model ? $this->model->newInstance($attributes) : $this->model->newModelInstance($attributes);
    }
}
