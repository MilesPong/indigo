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
            case 'push':
                if ($this->isDeployBranch($event->payload)) {
                    with(new Deployer)->deploy();
                }
            default:
        }
    }

    /**
     * @param $payload
     * @return bool
     */
    protected function isDeployBranch($payload)
    {
        $formattedPayload = $this->formatPayload($payload);

        return isset($formattedPayload['ref']) && (str_replace('refs/heads/', '',
                    $formattedPayload['ref']) === $this->getDeployBranch());
    }

    /**
     * @param $payload
     * @return mixed
     */
    protected function formatPayload($payload): mixed
    {
        return json_decode($payload, true);
    }

    /**
     * @return string
     */
    protected function getDeployBranch()
    {
        return config('indigo.deployer.branch', 'master');
    }
}
