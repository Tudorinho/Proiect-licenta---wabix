<?php

namespace App\Listeners\AfterCreate;

use App\Models\LeaveBalance;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AfterCreateLeaveListener
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
        if($event->context != 'Leave'){
            return;
        }
    }
}
