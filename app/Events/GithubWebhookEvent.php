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
    public $event;
    /**
     * @var
     */
    public $payload;

    /**
     * Create a new event instance.
     *
     * @param $event
     * @param $payload
     */
    public function __construct($event, $payload)
    {
        $this->event = $event;
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
