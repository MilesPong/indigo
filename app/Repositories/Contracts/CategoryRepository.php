<?php

namespace App\Repositories\Contracts;

use App\Repositories\Contracts\Helpers\HasPostInterface;
use App\Repositories\Contracts\Helpers\SlugableInterface;
use App\Repositories\Contracts\Repository as RepositoryInterface;

/**
 * Interface CategoryRepository
 * @package App\Repositories\Contracts
 */
interface CategoryRepository extends RepositoryInterface, SlugableInterface, HasPostInterface
{

}
