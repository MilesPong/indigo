<?php

namespace App\Listeners;

use App\Events\ViewedEvent;
use App\Indigo\Contracts\Counter;

/**
 * Class ViewedEventListener
 * @package App\Listeners
 */
class ViewedEventListener
{
    /**
     * @var \App\Indigo\Contracts\Counter
     */
    protected $counter;

    /**
     * ViewedEventListener constructor.
     * @param \App\Indigo\Contracts\Counter $counter
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
