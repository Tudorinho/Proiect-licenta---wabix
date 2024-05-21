<?php
$config =
    [
        "routesPrefix" => "tasks-lists-users",
        "controllerName" => "TaskListUserController",
        "modelName" => "TaskListUser",
        "translationKeyName" => "taskListUser",
        "translations" => [
            "plural" => "tasksListsUsers",
            "add" => "addTaskListUser",
            "edit" => "editTaskListUser"
        ],
        "table" => [
            "name" => "tasks_lists_users",
            "columns" => [
                [
                    "name" => "id"
                ],
                [
                    "name" => "user_id",
                    "type" => "foreignId",
                ],
                [
                    "name" => "tasks_lists_id",
                    "type" => "foreignId",
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
                "column" => "tasks_lists_id",
                "type" => "belongsTo",
                "name" => "taskList",
                "relatedModel" => "TaskList"
            ]
        ],
        "validators" => [
            "store" => [
                "user_id" => "required",
                "tasks_lists_id" => "required",
            ],
            "update" => [
                "user_id" => "required",
                "tasks_lists_id" => "required",
            ],
        ],
        "index" => [
            [
                "name" => "index",
            ],
            [
                "name" => "user_id",
                "value" => "\$row->user->email"
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
                    "name" => "tasks_lists_id",
                    "type" => "dropdown",
                    "model" => "TaskList",
                    "valuesName" => "tasksList",
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

