<?php

namespace App\Validators;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Validator;

class BeforeValidateWorklog
{
    public static function run(Validator $validator, Request $request, Authenticatable $user, $model = null){
        if(empty($model)){ //Create
            $currentUser = Auth::user();
            if($currentUser->role == 'employee') {
                $employee = Employee::where([
                    'user_id' => $currentUser->id
                ])->first();

                if ($request->employee_id != $employee->id) {
                    $validator->after(function($validator) use ($request, $user, $model){
                        $validator->errors()->add('employee_id', trans('translation.worklog.notAllowedToAssignThisEmployee'));
                    });
                }
            }
        } else{ //Update
            $validator->after(function($validator) use ($request, $user, $model){
                //$validator->errors()->add('key', 'value');
            });
        }

        return $validator;
    }
}
