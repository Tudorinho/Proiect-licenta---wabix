<?php
$config =
    [
        "routesPrefix" => "worklogs",
        "controllerName" => "WorklogController",
        "modelName" => "Worklog",
        "translationKeyName" => "worklog",
        "translations" => [
            "plural" => "worklogs",
            "add" => "addWorklog",
            "edit" => "editWorklog"
        ],
        "table" => [
            "name" => "worklogs",
            "columns" => [
                [
                    "name" => "id"
                ],
                [
                    "name" => "hours",
                    "type" => "float"
                ],
                [
                    "name" => "user_id",
                    "type" => "foreignId",
                    "nullable" => true
                ],
                [
                    "name" => "project_id",
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
            [
                "column" => "project_id",
                "type" => "belongsTo",
                "name" => "project",
                "relatedModel" => "Project"
            ],
        ],
        "validators" => [
            "store" => [
                "hours" => "required|numeric",
                "user_id" => "required",
                "project_id" => "required"
            ],
            "update" => [
                "hours" => "required|numeric",
                "user_id" => "required",
                "project_id" => "required"
            ]
        ],
        "index" => [
            [
                "name" => "index",
            ],
            [
                "name" => "hours"
            ],
            [
                "name" => "user_id",
                "value" => "\$row->user->email"
            ],
            [
                "name" => "project_id",
                "value" => "\$row->project->name"
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
                    "name" => "hours",
                    "type" => "string",
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
                [
                    "width" => 3,
                    "name" => "project_id",
                    "type" => "dropdown",
                    "model" => "Project",
                    "valuesName" => "projects",
                    "id" => "id",
                    "displayValue" => "name"
                ]
            ]
        ]
    ];

return $config;

