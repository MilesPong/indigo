<?php

namespace App\Listeners;

use App\Events\GithubWebhookEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Indigo\Tools\Deployer;

/**
 * Class GithubWebhookListener
 * @package App\Listeners
 */
class GithubWebhookListener implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  GithubWebhookEvent $event
     * @return void
     */
    public function handle(GithubWebhookEvent $event)
    {
        switch ($event->hookEvent) {
            case 'release':
                with(new Deployer)->release();
            default:
        }
    }
}
