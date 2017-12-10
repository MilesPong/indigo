<?php

namespace App\Listeners;

use App\Events\PostViewEvent;
use App\Services\PostViewCounter;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * Class PostViewEventListener
 * @package App\Listeners
 */
class PostViewEventListener
{
    /**
     * @var PostViewCounter
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
     * @param  PostViewEvent  $event
     * @return void
     */
    public function handle(PostViewEvent $event)
    {
        $this->counter->run($event->postId);
    }
}
