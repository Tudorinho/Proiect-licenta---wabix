<?php

namespace App\Validators;

use App\Models\ColdEmailingCredentials;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Validation\Validator;

class BeforeValidateColdEmailingCredentials
{
    public static function run(Validator $validator, Request $request, Authenticatable $user, $model = null){
        if(empty($model)){ //Create
            $validator->after(function($validator) use ($request, $user, $model){
                $connectionValidation = ColdEmailingCredentials::testConnection($request->username, $request->password);

                if(!empty($connectionValidation)){
                    $validator->errors()->add('email', 'Credentials validations failed. Username or password are wrong.');
                }
            });
        } else{ //Update
            $validator->after(function($validator) use ($request, $user, $model){
                $connectionValidation = ColdEmailingCredentials::testConnection($request->username, $request->password);

                if(!empty($connectionValidation)){
                    $validator->errors()->add('email', 'Credentials validations failed. Username or password are wrong.');
                }
            });
        }

        return $validator;
    }
}
