<?php
$config =
[
    "routesPrefix" => "employees",
    "controllerName" => "EmployeeController",
    "modelName" => "Employee",
    "translationKeyName" => "employee",
    "translations" => [
        "plural" => "employees",
        "add" => "addEmployee",
        "edit" => "editEmployee"
    ],
    "table"=> [
        "name" => "employees",
        "columns" => [
            [
                "name" => "id"
            ],
            [
                "name" => "first_name",
                "type" => "string"
            ],
            [
                "name" => "last_name",
                "type" => "string"
            ],
            [
                "name" => "gender",
                "type" => "enum",
                "values" => ["'male'", "'female'", "'other'"],
                "default" => "'other'"
            ],
            [
                "name" => "date_of_birth",
                "type" => "dateTime"
            ],
            [
                "name" => "email",
                "type" => "string",
                "nullable" => true
            ],
            [
                "name" => "user_id",
                "type" => "foreignId",
                "nullable" => true
            ],
            [
                "name" => "timestamps"
            ]
        ]
    ],
    "relationships" => [
        [
            "column" => "user_id",
            "type" => "belongsTo",
            "name" => "user",
            "relatedModel" => "User"
        ],
//        [
//            "column" => "customer_id",
//            "type" => "hasMany",
//            "name" => "customers",
//            "relatedModel" => "Customer"
//        ],
    ],
    "validators" => [
        "store" => [
            "first_name" => "required|max:255",
            "last_name" => "required|max:255",
            "gender" => "required|max:255",
            "date_of_birth" => "required",
            "user_id" => "required",
        ],
        "update" => [
            "first_name" => "required|max:255",
            "last_name" => "required|max:255",
            "gender" => "required|max:255",
            "date_of_birth" => "required",
            "user_id" => "required",
        ]
    ],
    "index" => [
        [
            "name" => "index",
        ],
        [
            "name" => "first_name"
        ],
        [
            "name" => "last_name"
        ],
        [
            "name" => "gender"
        ],
        [
            "name" => "date_of_birth",
        ],
        [
            "name" => "user_id",
            "value" => "\$row->user->first_name.' '.\$row->user->last_name"
        ],
        [
            "name" => "action",
            "types" => [
                "edit",
                "destroy"
            ]
        ]
    ],
    "createOrUpdate" => [
        "generalInformation" => [
            [
                "width" => 3,
                "name" => "first_name",
                "type" => "string",
            ],
            [
                "width" => 3,
                "name" => "last_name",
                "type" => "string",
            ],
            [
                "width" => 3,
                "name" => "gender",
                "type" => "dropdown",
                "values" => ["'male'", "'female'", "'other'"],
                "valuesName" => "genders",
            ],
            [
                "width" => 3,
                "name" => "date_of_birth",
                "type" => "datepicker",
//                "marginTop" => 3
            ],
        ],
        "accountInformation" => [
            [
                "width" => 3,
                "name" => "user_id",
                "type" => "dropdown",
                "model" => "User",
                "valuesName" => "users",
                "id" => "id",
                "displayValue" => "email"
            ]
        ]
    ]
];

return $config;

