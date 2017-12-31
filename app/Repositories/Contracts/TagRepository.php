<?php

namespace App\Repositories\Contracts;

use App\Repositories\Contracts\Repository as RepositoryInterface;

/**
 * Interface TagRepository
 * @package App\Repositories\Contracts
 */
interface TagRepository extends RepositoryInterface, SlugableInterface, HasPostInterface
{

}
