<?php

namespace App\Repositories\Contracts;

/**
 * Interface TagRepository
 * @package App\Repositories\Contracts
 */
interface TagRepository extends RepositoryInterface
{
    /**
     * @param array $attributes
     * @return mixed
     */
    public function createTag(array $attributes);

    /**
     * @param array $attributes
     * @param $id
     * @return mixed
     */
    public function updateTag(array $attributes, $id);

    /**
     * @param array $columns
     * @return mixed
     */
    public function allWithPostCount($columns = ['*']);
}
