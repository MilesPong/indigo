<?php

namespace App\Listeners;

use App\Events\ViewedEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Indigo\Contracts\Counter;

/**
 * Class ViewedEventListener
 * @package App\Listeners
 */
class ViewedEventListener implements ShouldQueue
{
    /**
     * @var \Indigo\Contracts\Counter
     */
    protected $counter;

    /**
     * ViewedEventListener constructor.
     * @param \Indigo\Contracts\Counter $counter
     */
    public function __construct(Counter $counter)
    {
        $this->counter = $counter;
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\ViewedEvent $event
     * @return void
     */
    public function handle(ViewedEvent $event)
    {
        $this->counter->increment($event->viewable);
    }
}
