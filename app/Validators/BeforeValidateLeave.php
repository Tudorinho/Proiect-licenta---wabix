<?php

namespace App\Validators;

use App\Models\Holiday;
use App\Models\Leave;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Validation\Validator;

class BeforeValidateLeave
{
    public static function run(Validator $validator, Request $request, Authenticatable $user, $model = null){
        if ($user->role == 'admin'){
            return $validator;
        }

        if(empty($model)){ //Create
            $validator->after(function($validator) use ($request, $user, $model){
                $data = Leave::getData($request->start_date, $request->end_date);
                $startDate = $data[0];
                $endDate = $data[1];
                $startDateYear = $data[2];
                $endDateYear = $data[3];
                $leaveDays = $data[4];
                $weekendDays = $data[5];
                $holidayDays = $data[6];
                $totalDays = $data[7];
                $daysBeforeLeave = $data[8];

                if($startDateYear != $endDateYear){
                    $validator->errors()->add('end_date', 'End date year must be the same as start date year.');
                }

                if($leaveDays <= 1){
                    if($daysBeforeLeave < 7){
                        $validator->errors()->add('start_date', 'For leaves with maximum 1 day you need to create leave 7 days prior.');
                    }
                } else if($leaveDays <= 5){
                    if($daysBeforeLeave < 21){
                        $validator->errors()->add('start_date', 'For leaves with maximum 5 days you need to create leave 21 days prior.');
                    }
                } else{
                    if($daysBeforeLeave < 30) {
                        $validator->errors()->add('start_date', 'For leaves with over 5 days you need to create leave 30 days prior.');
                    }
                }
            });
        } else{ //Update
            $validator->after(function($validator) use ($request, $user, $model){
                if($model->status != 'pending'){
                    $validator->errors()->add('status', 'Only pending status can be changed');
                }
            });
        }

        return $validator;
    }
}
