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
use Illuminate\Database\Eloquent\Builder;
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
    protected function applyScope()
    {
        if (isset($this->scopeQuery) && is_callable($this->scopeQuery)) {
            $this->model = call_user_func($this->scopeQuery, $this->model);
        }

        return $this;
    }

    /**
     * @return $this
     * @throws \App\Repositories\Exceptions\RepositoryException
     */
    protected function resetRepository()
    {
        $this->resetScope();

        $this->makeModel();

        return $this;
    }

    /**
     * @return $this
     */
    protected function resetScope()
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

        $this->resetRepository();

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
        $this->model = $this->model->with($relations);

        return $this;
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
     * @return $this|mixed
     */
    public function onlyTrashed()
    {
        // As noted [elsewhere] method_exists() does not care about
        // the existence of __call(), whereas is_callable() does.
        if (is_callable($this->model, $method = 'onlyTrashed')) {
            $this->model = call_user_func([$this->model, $method]);
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
        return $this->withTrashed()
            ->useResource(false)
            ->runQuery(function () use ($id) {
                $model = $this->model->findOrFail($id);

                if (is_callable($model, $method = 'restore')) {
                    $result = call_user_func([$model, $method]);
                }

                return $result ?? false;
            });
    }

    /**
     * @return $this|mixed
     */
    public function withTrashed()
    {
        // As noted [elsewhere] method_exists() does not care about
        // the existence of __call(), whereas is_callable() does.
        if (is_callable($this->model, $method = 'withTrashed')) {
            $this->model = call_user_func([$this->model, $method]);
        }

        return $this;
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
        $this->model = $this->model->limit($limit);

        return $this;
    }

    /**
     * @param $offset
     * @return $this
     */
    public function offset($offset)
    {
        $this->model = $this->model->offset($offset);

        return $this;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    public function getModelInstance()
    {
        return $this->model instanceof Builder ? $this->model->getModel() : $this->model;
    }

    /**
     * @param array $attributes
     * @return \Illuminate\Database\Eloquent\Model|static
     */
    protected function getNewModelInstance($attributes = [])
    {
        return $this->model instanceof Model ? $this->model->newInstance($attributes) : $this->model->newModelInstance($attributes);
    }
}
