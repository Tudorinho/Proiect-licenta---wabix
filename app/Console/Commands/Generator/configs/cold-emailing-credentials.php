<?php
$config =
    [
        "routesPrefix" => "cold-emailing-credentials",
        "controllerName" => "ColdEmailingCredentialsController",
        "modelName" => "ColdEmailingCredentials",
        "translationKeyName" => "coldEmailingCredentials",
        "translations" => [
            "plural" => "coldEmailingCredentials",
            "add" => "addColdEmailingCredentials",
            "edit" => "editColdEmailingCredentials"
        ],
        "table" => [
            "name" => "cold-emailing-credentials",
            "columns" => [
                [
                    "name" => "id"
                ],
                [
                    "name" => "email",
                    "type" => "string",
                ],
                [
                    "name" => "username",
                    "type" => "string"
                ],
                [
                    "name" => "password",
                    "type" => "string"
                ],
                [
                    "name" => "timestamps"
                ]
            ]
        ],
        "relationships" => [
        ],
        "validators" => [
            "store" => [
                "email" => "required",
                "username" => "required",
                "password" => "required",
            ],
            "update" => [
                "email" => "required",
                "username" => "required",
                "password" => "required",
            ],
        ],
        "index" => [
            [
                "name" => "index",
            ],
            [
                "name" => "email",
            ],
            [
                "name" => "username",
            ],
            [
                "name" => "validated",
            ],
            [
                "name" => "last_error",
            ],
            [
                "name" => "created_at",
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
                    "width" => 4,
                    "name" => "email",
                    "type" => "string"
                ],
                [
                    "width" => 4,
                    "name" => "username",
                    "type" => "string"
                ],
                [
                    "width" => 4,
                    "name" => "password",
                    "type" => "string"
                ]
            ]
        ]
    ];

return $config;

