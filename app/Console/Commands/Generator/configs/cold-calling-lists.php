<?php
$config =
    [
        "routesPrefix" => "cold-calling-lists",
        "controllerName" => "ColdCallingListsController",
        "modelName" => "ColdCallingList",
        "translationKeyName" => "coldCallingLists",
        "translations" => [
            "plural" => "coldCallingLists",
            "add" => "addColdCallingLists",
            "edit" => "editColdCallingLists"
        ],
        "table" => [
            "name" => "cold_calling_lists",
            "columns" => [
                [
                    "name" => "id"
                ],
                [
                    "name" => "name",
                    "type" => "string",
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
                "column" => "tasks_lists_id",
                "type" => "belongsTo",
                "name" => "taskList",
                "relatedModel" => "TaskList"
            ],
        ],
        "validators" => [
            "store" => [
                "name" => "required",
                "tasks_lists_id" => "required"
            ],
            "update" => [
                "name" => "required",
                "tasks_lists_id" => "required"
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
                ]
            ]
        ]
    ];

return $config;

