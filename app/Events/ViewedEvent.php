<?php

namespace App\Events;

use Crawler;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;
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
     * @var bool
     */
    public $isAuth = false;
    /**
     * @var bool
     */
    public $isRobot = false;

    /**
     * ViewedEvent constructor.
     * @param \Indigo\Contracts\Viewable $viewable
     */
    public function __construct(Viewable $viewable)
    {
        $this->viewable = $viewable;

        // TODO maybe should be placed into Listener?
        $this->isAuth = Auth::check();
        $this->isRobot = Crawler::isCrawler();
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
