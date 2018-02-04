<?php

namespace App\Events;

use App\Indigo\Contracts\Viewable;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

/**
 * Class ViewedEvent
 * @package App\Events
 */
class ViewedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var \App\Indigo\Contracts\Viewable
     */
    public $viewable;

    /**
     * ViewedEvent constructor.
     * @param \App\Indigo\Contracts\Viewable $viewable
     */
    public function __construct(Viewable $viewable)
    {
        $this->viewable = $viewable;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
