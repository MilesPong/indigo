<?php

namespace App\Repositories\Contracts;

use App\Repositories\Contracts\Helpers\ApiResourceInterface;
use App\Repositories\Contracts\Helpers\HasCriteriaInterface;
use Closure;

/**
 * Interface Repository
 * @package App\Repositories\Contracts
 */
interface Repository extends ApiResourceInterface, HasCriteriaInterface
{
    /**
     * @param array $columns
     * @return mixed
     */
    public function findAll($columns = ['*']);

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
     * @param $relations
     * @return $this
     */
    public function with($relations);

    /**
     * Add sub-select queries to count the relations.
     *
     * @param mixed $relations
     * @return $this
     */
    public function withCount($relations);

    /**
     * @param array $attributes
     * @return mixed
     */
    public function firstOrCreate(array $attributes = []);

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
     * @param $column
     * @param string $direction
     * @return mixed
     */
    public function orderBy($column, $direction = 'asc');

    /**
     * @param \Closure $callback
     * @return mixed
     */
    public function scopeQuery(Closure $callback);

    /**
     * @param array $columns
     * @return mixed
     */
    public function first($columns = ['*']);

    /**
     * @param $limit
     * @return $this
     */
    public function limit($limit);

    /**
     * @param $offset
     * @return $this
     */
    public function offset($offset);
}