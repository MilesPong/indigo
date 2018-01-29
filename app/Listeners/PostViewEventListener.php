<?php

namespace App\Listeners;

use App\Events\PostViewEvent;
use Indigo\Post\PostViewCounter;

/**
 * Class PostViewEventListener
 * @package App\Listeners
 */
class PostViewEventListener
{
    /**
     * @var \Indigo\Post\PostViewCounter
     */
    protected $counter;

    /**
     * PostViewEventListener constructor.
     * @param PostViewCounter $postViewCounter
     */
    public function __construct(PostViewCounter $postViewCounter)
    {
        $this->counter = $postViewCounter;
    }

    /**
     * Handle the event.
     *
     * @param  PostViewEvent $event
     * @return void
     */
    public function handle(PostViewEvent $event)
    {
        $this->counter->run($event->postId);
    }
}
