<?php

namespace App\Repositories\Events;

/**
 * Class RepositoryEntityCreated
 * @package App\Repositories\Events
 */
class RepositoryEntityCreated extends BaseEvent
{
    /**
     * @var string
     */
    protected $action = 'created';
}
