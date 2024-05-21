<?php

namespace App\Listeners\AfterCreate;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AfterCreateEmailThreadListener
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
        if($event->context != 'EmailThread'){
            return;
        }
    }
}
