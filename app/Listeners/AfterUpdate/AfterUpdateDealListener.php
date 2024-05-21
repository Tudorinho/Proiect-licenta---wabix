<?php

namespace App\Listeners\AfterUpdate;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AfterUpdateDealListener
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
        if($event->context != 'Deal'){
            return;
        }
    }
}
