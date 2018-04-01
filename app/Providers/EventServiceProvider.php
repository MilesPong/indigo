<?php

namespace App\Providers;

use App\Events\GithubWebhookEvent;
use App\Listeners\GithubWebhookListener;
use App\Repositories\Listeners\RepositoryEventSubscriber;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        // 'App\Events\Event' => [
        //     'App\Listeners\EventListener',
        // ],
        'App\Events\ViewedEvent' => [
            'App\Listeners\ViewedEventListener',
        ],
        GithubWebhookEvent::class => [
            GithubWebhookListener::class
        ]
    ];

    /**
     * @var array
     */
    protected $subscribe = [
        // RepositoryEventSubscriber::class
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
