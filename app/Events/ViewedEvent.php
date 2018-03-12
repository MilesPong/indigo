<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Indigo\Contracts\Viewable;

/**
 * Class ViewedEvent
 * @package App\Events
 */
class ViewedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var \Indigo\Contracts\Viewable
     */
    public $viewable;

    /**
     * ViewedEvent constructor.
     * @param \Indigo\Contracts\Viewable $viewable
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
