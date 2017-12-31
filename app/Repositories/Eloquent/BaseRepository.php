<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Contracts\Repository as RepositoryInterface;
use App\Repositories\Events\RepositoryEntityCreated;
use App\Repositories\Events\RepositoryEntityDeleted;
use App\Repositories\Events\RepositoryEntityUpdated;
use App\Repositories\Exceptions\RepositoryException;
use Closure;
use Illuminate\Container\Container;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * Class BaseRepository
 * @package App\Repositories\Eloquent
 */
abstract class BaseRepository implements RepositoryInterface
{
    /**
     * Default not to use resource.
     *
     * @var bool
     */
    public $useResource = false;
    /**
     * @var Container
     */
    protected $app;
    /**
     * @var Model|Builder
     */
    protected $model;
    /**
     * @var array
     */
    protected $relations = [];
    /**
     * @var Closure
     */
    protected $scopeQuery;

    /**
     * BaseRepository constructor.
     * @param Container $app
     * @throws RepositoryException
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
     * @param bool $switch
     * @return $this
     */
    public function useResource($switch = true)
    {
        $this->useResource = $switch;

        return $this;
    }

    /**
     * @return Builder|Model
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
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     * @throws RepositoryException
     */
    public function all($columns = ['*'])
    {
        $this->scopeBoot();

        $this->applyScope();

        if ($this->model instanceof Builder) {
            $result = $this->model->get($columns);
        } else {
            $result = $this->model->all($columns);
        }

        $this->resetModel();
        $this->resetScope();

        return $this->parseResult($result);
    }

    /**
     * The fake "booting" method of the model in calling scopes.
     */
    public function scopeBoot()
    {

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
     * Reset the model after query
     */
    protected function resetModel()
    {
        try {
            $this->makeModel();
        } catch (RepositoryException $exception) {
            return false;
        }

        return true;
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
     * @throws RepositoryException
     */
    protected function parseResult($result)
    {
        if (!$this->useResource) {
            return $result;
        }

        return $this->parseThroughResource($result);
    }

    /**
     * @param $data
     * @return mixed
     * @throws RepositoryException
     */
    protected function parseThroughResource($data)
    {
        $resource = $this->resource();

        if (is_null($resource)) {
            throw new RepositoryException('Resource is not defined yet.');
        }

        if ($data instanceof Collection || $data instanceof LengthAwarePaginator) {
            return call_user_func_array([$resource, 'collection'], [$data]);
        } elseif (is_null($data)) {
            $data = collect([]);
        }

        return call_user_func_array([$resource, 'make'], [$data]);
    }

    /**
     * @return null
     */
    public function resource()
    {
        return null;
    }

    /**
     * @param int $perPage
     * @param array $columns
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     * @throws RepositoryException
     */
    public function paginate($perPage = null, $columns = ['*'])
    {
        $this->scopeBoot();

        $this->applyScope();

        $perPage = $perPage ?: $this->getDefaultPerPage();

        $result = $this->model->paginate($perPage ?: $perPage, $columns);

        $this->resetModel();
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
     * @return Model
     */
    public function create(array $attributes)
    {
        return tap($this->model->create($attributes), function ($model) {
            event(new RepositoryEntityCreated($this, $model));
        });
    }

    /**
     * @param array $attributes
     * @param $id
     * @return \Illuminate\Database\Eloquent\Collection|Model
     */
    public function update(array $attributes, $id)
    {
        $this->scopeBoot();

        $this->applyScope();

        $model = $this->model->findOrFail($id);
        $model->fill($attributes);
        $model->save();

        event(new RepositoryEntityUpdated($this, $model));

        $this->resetModel();
        $this->resetScope();

        return $model;
    }

    /**
     * @param $id
     * @return int
     * @throws \Exception
     */
    public function delete($id)
    {
        $this->scopeBoot();

        $this->applyScope();

        $model = $this->find($id);
        $originalModel = clone $model;

        $deleted = $model->delete();

        event(new RepositoryEntityDeleted($this, $originalModel));

        $this->resetModel();
        $this->resetScope();

        return $deleted;
    }

    /**
     * @param $id
     * @param array $columns
     * @return \Illuminate\Database\Eloquent\Collection|Model
     * @throws RepositoryException
     */
    public function find($id, $columns = ['*'])
    {
        $this->scopeBoot();

        $this->applyScope();

        $result = $this->model->findOrFail($id, $columns);

        $this->resetModel();
        $this->resetScope();

        return $this->parseResult($result);
    }

    /**
     * @param $field
     * @param $value
     * @param array $columns
     * @return mixed
     * @throws RepositoryException
     */
    public function firstBy($field, $value, $columns = ['*'])
    {
        $this->scopeBoot();

        $this->applyScope();

        $result = $this->model->where($field, '=', $value)->first($columns);

        $this->resetModel();
        $this->resetScope();

        return $this->parseResult($result);
    }

    /**
     * @param $field
     * @param $value
     * @param array $columns
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     * @throws RepositoryException
     */
    public function allBy($field, $value, $columns = ['*'])
    {
        $this->scopeBoot();

        $this->applyScope();

        $result = $this->model->where($field, '=', $value)->get($columns);

        $this->resetModel();
        $this->resetScope();

        return $this->parseResult($result);
    }

    /**
     * @param array $where
     * @param array $columns
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     * @throws RepositoryException
     */
    public function getByWhere(array $where, $columns = ['*'])
    {
        $this->scopeBoot();

        $this->applyScope();

        $this->applyConditions($where);

        $result = $this->model->get($columns);

        $this->resetModel();
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
     * @return Model
     * @throws RepositoryException
     */
    public function firstOrCreate(array $attributes = [])
    {
        $this->scopeBoot();

        $this->applyScope();

        $result = $this->model->firstOrCreate($attributes);

        $this->resetModel();
        $this->resetScope();

        return $this->parseResult($result);
    }

    /**
     * @return BaseRepository
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
     * @throws RepositoryException
     */
    public function restore($id)
    {
        $this->scopeBoot();

        $this->applyScope();

        $result = $this->withTrashed()->find($id)->restore();

        $this->resetModel();
        $this->resetScope();

        return $this->parseResult($result);
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
     * @return bool|null
     * @throws RepositoryException
     */
    public function forceDelete($id)
    {
        $this->scopeBoot();

        $this->applyScope();

        $result = $this->withTrashed()->find($id)->forceDelete();

        $this->resetModel();
        $this->resetScope();

        return $this->parseResult($result);
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
     * @param Closure|null $callback
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
     * @param Closure $callback
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
     * @throws RepositoryException
     */
    public function first($columns = ['*'])
    {
        $this->scopeBoot();

        $this->applyScope();

        $result = $this->model->first($columns);

        $this->resetModel();
        $this->resetScope();

        return $this->parseResult($result);
    }
}
