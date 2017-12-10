<?php

namespace App\Repositories\Events;

use App\Repositories\Contracts\RepositoryInterface;
use Illuminate\Database\Eloquent\Model;

/**
 * Class BaseEvent
 * @package App\Repositories\Events
 */
abstract class BaseEvent
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * @var RepositoryInterface
     */
    protected $repository;

    /**
     * @var
     */
    protected $action;

    /**
     * BaseEvent constructor.
     * @param $repository
     * @param $model
     */
    public function __construct(RepositoryInterface $repository, Model $model)
    {
        $this->model = $model;
        $this->repository = $repository;
    }

    /**
     * @return Model
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @return RepositoryInterface
     */
    public function getRepository()
    {
        return $this->repository;
    }

    /**
     * @return mixed
     */
    public function getAction()
    {
        return $this->action;
    }
}
