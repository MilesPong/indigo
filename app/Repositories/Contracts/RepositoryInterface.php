<?php

namespace App\Repositories\Contracts;

use Closure;

/**
 * Interface RepositoryInterface
 * @package App\Repositories\Contracts
 */
interface RepositoryInterface
{
    /**
     * @param array $columns
     * @return mixed
     */
    public function all($columns = ['*']);

    /**
     * @param int $perPage
     * @param array $columns
     * @return mixed
     */
    public function paginate($perPage = null, $columns = ['*']);

    /**
     * @param array $attributes
     * @return mixed
     */
    public function create(array $attributes);

    /**
     * @param array $attributes
     * @param $id
     * @return mixed
     */
    public function update(array $attributes, $id);

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id);

    /**
     * @param $id
     * @param array $columns
     * @return mixed
     */
    public function find($id, $columns = ['*']);

    /**
     * @param $field
     * @param $value
     * @param array $columns
     * @return mixed
     */
    public function findBy($field, $value, $columns = ['*']);

    /**
     * @param $field
     * @param $value
     * @param array $columns
     * @return mixed
     */
    public function findAllBy($field, $value, $columns = ['*']);

    /**
     * @param array $where
     * @param array $columns
     * @return mixed
     */
    public function findWhere(array $where, $columns = ['*']);

    /**
     * @param $relations
     * @return $this
     */
    public function with($relations);

    /**
     * Add subselect queries to count the relations.
     *
     * @param  mixed $relations
     * @return $this
     */
    public function withCount($relations);

    /**
     * @param $relation
     * @return mixed
     */
    public function has($relation);

    /**
     * @param $relation
     * @param Closure|null $callback
     * @return mixed
     */
    public function whereHas($relation, Closure $callback = null);

    /**
     * @param array $attributes
     * @return mixed
     */
    public function firstOrCreate(array $attributes = []);

    /**
     * @param bool $only
     * @return mixed
     */
    public function trashed($only = false);

    /**
     * @return mixed
     */
    public function onlyTrashed();

    /**
     * @return mixed
     */
    public function withTrashed();

    /**
     * @param $id
     * @return mixed
     */
    public function restore($id);

    /**
     * @param $id
     * @return mixed
     */
    public function forceDelete($id);

    /**
     * @return mixed
     */
    public function getModel();

    /**
     * @return mixed
     */
    public function getModelTable();

    /**
     * @param $column
     * @param string $direction
     * @return mixed
     */
    public function orderBy($column, $direction = 'asc');

    /**
     * @param Closure $callback
     * @return mixed
     */
    public function scopeQuery(Closure $callback);

    /**
     * @return mixed
     */
    public function resetScope();

    /**
     * @param array $columns
     * @return mixed
     */
    public function first($columns = ['*']);
}