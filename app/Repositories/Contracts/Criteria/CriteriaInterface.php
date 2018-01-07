<?php

namespace App\Repositories\Contracts\Criteria;

/**
 * Interface CriteriaInterface
 * @package App\Repositories\Contracts
 */
interface CriteriaInterface
{
    /**
     * @param \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Builder $model
     * @param \App\Repositories\Contracts\Repository $repository
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Builder
     */
    public function apply($model, $repository);
}