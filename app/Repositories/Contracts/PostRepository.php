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
}
