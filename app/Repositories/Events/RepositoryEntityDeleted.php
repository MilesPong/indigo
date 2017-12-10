<?php

namespace App\Repositories\Events;

/**
 * Class RepositoryEntityDeleted
 * @package App\Repositories\Events
 */
class RepositoryEntityDeleted extends BaseEvent
{
    /**
     * @var string
     */
    protected $action = 'deleted';
}
