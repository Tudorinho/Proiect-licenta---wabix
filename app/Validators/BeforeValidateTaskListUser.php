<?php

namespace App\Validators;

use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Validation\Validator;

class BeforeValidateTaskListUser
{
    public static function run(Validator $validator, Request $request, Authenticatable $user, $model = null){
        if(empty($model)){ //Create
            $validator->after(function($validator) use ($request, $user, $model){
                //$validator->errors()->add('key', 'value');
            });
        } else{ //Update
            $validator->after(function($validator) use ($request, $user, $model){
                //$validator->errors()->add('key', 'value');
            });
        }

        return $validator;
    }
}
