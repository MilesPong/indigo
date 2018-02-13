<?php

namespace App\Repositories\Contracts;

use App\Repositories\Contracts\Helpers\SlugableInterface;
use App\Repositories\Contracts\Repository as RepositoryInterface;

/**
 * Interface PageRepository
 * @package App\Repositories\Contracts
 */
interface PageRepository extends RepositoryInterface, SlugableInterface
{
}