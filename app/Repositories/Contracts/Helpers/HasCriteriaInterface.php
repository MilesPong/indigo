<?php

namespace App\Repositories\Contracts\Helpers;

/**
 * Interface HasCriteriaInterface
 * @package App\Repositories\Contracts\Helpers
 */
interface HasCriteriaInterface
{
    /**
     * @param $criteria
     * @return mixed
     */
    public function pushCriteria($criteria);

    /**
     * @param $criteria
     * @return mixed
     */
    public function popCriteria($criteria);

    /**
     * @param bool $status
     * @return mixed
     */
    public function skipCriteria($status = true);

    /**
     * @param $criteria
     * @return mixed
     */
    public function useCriteria($criteria);

    /**
     * @return mixed
     */
    public function applyCriteria();

    /**
     * @return mixed
     */
    public function resetCriteria();

    /**
     * @return mixed
     */
    public function getCriteria();
}
