<?php

namespace App\Repositories\Contracts;

use App\Repositories\Contracts\Repository as RepositoryInterface;

/**
 * Interface CategoryRepository
 * @package App\Repositories\Contracts
 */
interface CategoryRepository extends RepositoryInterface, SlugInterface, HasPostInterface
{
    /**
     * @param array $attributes
     * @return mixed
     */
    public function createCategory(array $attributes);

    /**
     * @param array $attributes
     * @param $id
     * @return mixed
     */
    public function updateCategory(array $attributes, $id);
}
