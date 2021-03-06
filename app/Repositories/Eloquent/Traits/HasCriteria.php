<?php

namespace App\Repositories\Eloquent\Traits;

use App\Repositories\Contracts\Criteria\CriteriaInterface;
use App\Repositories\Exceptions\RepositoryException;

/**
 * Trait HasCriteria
 * @package App\Repositories\Eloquent\Traits
 */
trait HasCriteria
{
    /**
     * @var array
     */
    protected $criteria = [];
    /**
     * @var bool
     */
    protected $skipCriteria = false;

    /**
     * @param $criteria
     * @return mixed
     * @throws \App\Repositories\Exceptions\RepositoryException
     * @see \App\Repositories\Contracts\Helpers\HasCriteriaInterface::pushCriteria()
     */
    public function pushCriteria($criteria)
    {
        $criteria = $this->parseCriteria($criteria);

        array_push($this->criteria, $criteria);

        return $this;
    }

    /**
     * @param $criteria
     * @return \App\Repositories\Contracts\Criteria\CriteriaInterface
     * @throws \App\Repositories\Exceptions\RepositoryException
     */
    protected function parseCriteria($criteria)
    {
        if (is_string($criteria)) {
            $criteria = new $criteria;
        }

        if (!$criteria instanceof CriteriaInterface) {
            throw new RepositoryException("Class " . get_class($criteria) . " must be an instance of " . RepositoryException::class);
        }

        return $criteria;
    }

    /**
     * @param $criteria
     * @return mixed
     * @see \App\Repositories\Contracts\Helpers\HasCriteriaInterface::popCriteria()
     */
    public function popCriteria($criteria)
    {
        $this->criteria = array_filter($this->criteria, function ($c) use ($criteria) {
            // $c is always an instance of CriteriaInterface
            if (is_string($criteria)) {
                return $criteria !== get_class($c);
            }

            return get_class($criteria) !== get_class($c);
        });

        return $this;
    }

    /**
     * @param bool $status
     * @return mixed
     * @see \App\Repositories\Contracts\Helpers\HasCriteriaInterface::skipCriteria()
     */
    public function skipCriteria($status = true)
    {
        $this->skipCriteria = $status;

        return $this;
    }

    /**
     * @param $criteria
     * @return mixed
     * @throws \App\Repositories\Exceptions\RepositoryException
     * @see \App\Repositories\Contracts\Helpers\HasCriteriaInterface::useCriteria()
     */
    public function useCriteria($criteria)
    {
        $criteria = $this->parseCriteria($criteria);

        $this->model = $criteria->apply($this->model, $this);

        return $this;
    }

    /**
     * @return mixed
     * @see \App\Repositories\Contracts\Helpers\HasCriteriaInterface::applyCriteria()
     */
    public function applyCriteria()
    {
        if ($this->skipCriteria) {
            return $this;
        }

        foreach ($this->criteria as $criteria) {
            if ($criteria instanceof CriteriaInterface) {
                $this->model = $criteria->apply($this->model, $this);
            }
        }

        return $this;
    }

    /**
     * @return array
     * @see \App\Repositories\Contracts\Helpers\HasCriteriaInterface::getCriteria()
     */
    public function getCriteria()
    {
        return $this->criteria;
    }

    /**
     * @return $this
     * @see \App\Repositories\Contracts\Helpers\HasCriteriaInterface::resetCriteria()
     */
    public function resetCriteria()
    {
        $this->criteria = [];

        return $this;
    }
}