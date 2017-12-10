<?php

namespace App\Repositories\Listeners;

use App\Repositories\Events\RepositoryEntityCreated;
use App\Repositories\Events\RepositoryEntityDeleted;
use App\Repositories\Events\RepositoryEntityUpdated;

class RepositoryEventSubscriber
{
    public function subscribe($events)
    {
        $events->listen(
            RepositoryEntityCreated::class,
            'App\Repositories\Listeners\RepositoryEventSubscriber@cleanCache'
        );
        $events->listen(
            RepositoryEntityUpdated::class,
            'App\Repositories\Listeners\RepositoryEventSubscriber@cleanCache'
        );
        $events->listen(
            RepositoryEntityDeleted::class,
            'App\Repositories\Listeners\RepositoryEventSubscriber@cleanCache'
        );
    }

    public function cleanCache($event)
    {

    }
}