<?php

namespace App\Repositories\Contracts;

use App\Repositories\Contracts\Repository as RepositoryInterface;

/**
 * Interface TagRepository
 * @package App\Repositories\Contracts
 */
interface TagRepository extends RepositoryInterface, SlugInterface, HasPostInterface
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
}
