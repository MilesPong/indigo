<?php

namespace App\Repositories\Contracts;

use App\Repositories\Contracts\Repository as RepositoryInterface;

/**
 * Interface VisitorRepository
 * @package App\Repositories\Contracts
 */
interface VisitorRepository extends RepositoryInterface
{
    /**
     * @return mixed
     */
    public function createLog();
}
