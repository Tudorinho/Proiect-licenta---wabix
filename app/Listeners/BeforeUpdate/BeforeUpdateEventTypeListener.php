<?php

namespace App\Listeners\BeforeUpdate;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class BeforeUpdateEventTypeListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        if($event->context != 'EventType'){
            return;
        }
    }
}
