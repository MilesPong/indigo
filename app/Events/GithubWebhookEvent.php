<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * Class GithubWebhookEvent
 * @package App\Events
 */
class GithubWebhookEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    /**
     * @var
     */
    public $hookEvent;
    /**
     * @var
     */
    public $payload;

    /**
     * Create a new event instance.
     *
     * @param $hookEvent
     * @param $payload
     */
    public function __construct($hookEvent, $payload)
    {
        $this->hookEvent = $hookEvent;
        $this->payload = $payload;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
