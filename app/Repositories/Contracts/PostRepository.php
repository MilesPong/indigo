<?php

namespace App\Repositories\Contracts;

/**
 * Interface PostRepository
 * @package App\Repositories\Contracts
 */
interface PostRepository extends RepositoryInterface
{
    /**
     * @param array $attributes
     * @return mixed
     */
    public function createPost(array $attributes);

    /**
     * @param array $attributes
     * @param $id
     * @return mixed
     */
    public function updatePost(array $attributes, $id);

    /**
     * @param null $perPage
     * @return mixed
     */
    public function lists($perPage = null);

    /**
     * @param $id
     * @return mixed
     */
    public function retrieve($id);

    /**
     * @param $slug
     * @return mixed
     */
    public function getBySlug($slug);

    /**
     * @param $model
     * @return mixed
     */
    public function previous($model);

    /**
     * @param $model
     * @return mixed
     */
    public function next($model);
}
