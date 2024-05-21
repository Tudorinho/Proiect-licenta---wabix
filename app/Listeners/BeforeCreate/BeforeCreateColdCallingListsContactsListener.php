<?php

namespace App\Listeners\BeforeCreate;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class BeforeCreateColdCallingListsContactsListener
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
        if($event->context != 'ColdCallingListsContacts'){
            return;
        }
    }
}
