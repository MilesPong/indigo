<?php

namespace App\Repositories\Contracts;

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
