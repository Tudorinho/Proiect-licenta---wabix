<?php

namespace App\Listeners\AfterUpdate;

use App\Models\Leave;
use App\Models\LeaveBalance;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AfterUpdateLeaveListener
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

        if($event->originalModelAttributes['status'] == 'pending' && $event->model->status == 'approved'){
            $leaveBalance = LeaveBalance::where([
                'year' => $event->model->year,
                'employee_id' => $event->model->employee_id,
                'leaves_types_id' => $event->model->leaves_types_id
            ])->first();
            if (empty($leaveBalance)){
                $leaveBalance = LeaveBalance::create([
                    'year' => $event->model->year,
                    'employee_id' => $event->model->employee_id,
                    'leaves_types_id' => $event->model->leaves_types_id,
                    'balance' => 0
                ]);
            }

            $leaveBalance->balance = $leaveBalance->balance - $event->model->leave_days;
            $leaveBalance->save();
        }
    }
}
