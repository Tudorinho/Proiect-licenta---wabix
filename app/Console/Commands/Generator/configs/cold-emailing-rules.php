<?php
$config =
    [
        "routesPrefix" => "cold-emailing-rules",
        "controllerName" => "ColdEmailingRulesController",
        "modelName" => "ColdEmailingRules",
        "translationKeyName" => "coldEmailingRules",
        "translations" => [
            "plural" => "coldEmailingRules",
            "add" => "addColdEmailingRules",
            "edit" => "editColdEmailingRules"
        ],
        "table" => [
            "name" => "cold_emailing_rules",
            "columns" => [
                [
                    "name" => "id"
                ],
                [
                    "name" => "name",
                    "type" => "string",
                ],
                [
                    "name" => "cold_emailing_credentials_id",
                    "type" => "foreignId"
                ],
                [
                    "name" => "subject",
                    "type" => "string",
                    "nullable" => true
                ],
                [
                    "name" => "since",
                    "type" => "datetime",
                    "nullable" => true
                ],
                [
                    "name" => "before",
                    "type" => "datetime",
                    "nullable" => true
                ],
                [
                    "name" => "last_check_date",
                    "type" => "datetime",
                    "nullable" => true
                ],
                [
                    "name" => "user_id",
                    "type" => "foreignId"
                ],
                [
                    "name" => "tasks_lists_id",
                    "type" => "foreignId"
                ],
                [
                    "name" => "timestamps"
                ]
            ]
        ],
        "relationships" => [
            [
                "column" => "cold_emailing_credentials_id",
                "type" => "belongsTo",
                "name" => "coldEmailingCredential",
                "relatedModel" => "ColdEmailingCredentials"
            ],
            [
                "column" => "user_id",
                "type" => "belongsTo",
                "name" => "user",
                "relatedModel" => "User"
            ],
            [
                "column" => "tasks_lists_id",
                "type" => "belongsTo",
                "name" => "taskList",
                "relatedModel" => "TaskList"
            ],
        ],
        "validators" => [
            "store" => [
                "name" => "required",
                "cold_emailing_credentials_id" => "required"
            ],
            "update" => [
                "name" => "required",
                "cold_emailing_credentials_id" => "required"
            ],
        ],
        "index" => [
            [
                "name" => "index",
            ],
            [
                "name" => "name",
            ],
            [
                "name" => "cold_emailing_credentials_id",
                "value" => "\$row->coldEmailingCredential->email"
            ],
            [
                "name" => "subject",
            ],
            [
                "name" => "last_check_date",
            ],
            [
                "name" => "tasks_lists_id",
                "value" => "\$row->taskList->name"
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
                    "name" => "name",
                    "type" => "string"
                ],
                [
                    "width" => 3,
                    "name" => "cold_emailing_credentials_id",
                    "type" => "dropdown",
                    "model" => "ColdEmailingCredentials",
                    "valuesName" => "coldEmailingCredentials",
                    "id" => "id",
                    "displayValue" => "email"
                ],
            ],
            "searchCriteria" => [
                [
                    "width" => 3,
                    "name" => "subject",
                    "type" => "string"
                ],
                [
                    "width" => 3,
                    "name" => "since",
                    "type" => "datepicker"
                ],
                [
                    "width" => 3,
                    "name" => "before",
                    "type" => "datepicker"
                ]
            ],
            "taskConfiguration" => [
                [
                    "width" => 3,
                    "name" => "tasks_lists_id",
                    "type" => "dropdown",
                    "model" => "TaskList",
                    "valuesName" => "tasksLists",
                    "id" => "id",
                    "displayValue" => "name"
                ],
                [
                    "width" => 3,
                    "name" => "user_id",
                    "type" => "dropdown",
                    "model" => "User",
                    "valuesName" => "users",
                    "id" => "id",
                    "displayValue" => "email"
                ],
            ]
        ]
    ];

return $config;

