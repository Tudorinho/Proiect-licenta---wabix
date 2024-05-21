<?php
$config =
[
    "routesPrefix" => "users",
    "controllerName" => "UserController",
    "modelName" => "User",
    "translationKeyName" => "user",
    "translations" => [
        "plural" => "users",
        "add" => "addUser",
        "edit" => "editUser"
    ],
    "table" => [
        "name" => "users"
    ],
    "validators" => [
        "store" => [
            "email" => "required",
            "password" => "required",
            "role" => "required"
        ],
        "update" => [
            "email" => "required",
            "password" => "required",
            "role" => "required"
        ]
    ],
    "index" => [
        [
            "name" => "index",
        ],
        [
            "name" => "email"
        ],
        [
            "name" => "role"
        ],
        [
            "name" => "created_at"
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
                "name" => "email",
                "type" => "string",
            ],
            [
                "width" => 3,
                "name" => "role",
                "type" => "dropdown",
                "values" => ["'employee'", "'admin'"],
                "valuesName" => "roles",
            ],
            [
                "width" => 3,
                "name" => "password",
                "type" => "password"
            ],
        ]
    ]
];

return $config;

