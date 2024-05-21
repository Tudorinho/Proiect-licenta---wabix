<?php
$config =
    [
        "routesPrefix" => "tasks-statuses-changes",
        "controllerName" => "TaskStatusChangeController",
        "modelName" => "TaskStatusChange",
        "translationKeyName" => "taskStatusChange",
        "translations" => [
            "plural" => "tasksStatusesChanges",
            "add" => "addTaskStatusChange",
            "edit" => "editTaskStatusChange"
        ],
        "table" => [
            "name" => "tasks_statuses_changes",
            "columns" => [
                [
                    "name" => "id"
                ],
                [
                    "name" => "task_id",
                    "type" => "foreignId",
                ],
                [
                    "name" => "from_status",
                    "type" => "string",
                ],
                [
                    "name" => "to_status",
                    "type" => "string",
                ],
                [
                    "name" => "user_id",
                    "type" => "foreignId",
                ],
                [
                    "name" => "timestamps"
                ]
            ]
        ],
        "relationships" => [
            [
                "column" => "task_id",
                "type" => "belongsTo",
                "name" => "task",
                "relatedModel" => "Task"
            ],
            [
                "column" => "user_id",
                "type" => "belongsTo",
                "name" => "user",
                "relatedModel" => "User"
            ]
        ],
        "validators" => [
            "store" => [
                "task_id" => "required",
                "user_id" => "required",
                "from_status" => "required",
                "to_status" => "required",
            ],
            "update" => [
                "task_id" => "required",
                "user_id" => "required",
                "from_status" => "required",
                "to_status" => "required",
            ],
        ],
        "index" => [
            [
                "name" => "index",
            ],
            [
                "name" => "task_id",
                "value" => "\$row->task->title"
            ],
            [
                "name" => "user_id",
                "value" => "\$row->user->email"
            ],
            [
                "name" => "from_status",
            ],
            [
                "name" => "to_status",
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
                    "name" => "task_id",
                    "type" => "dropdown",
                    "model" => "Task",
                    "valuesName" => "tasks",
                    "id" => "id",
                    "displayValue" => "title"
                ],
                [
                    "width" => 3,
                    "name" => "from_status",
                    "type" => "dropdown",
                    "values" => ["'pending'", "'done'"],
                    "valuesName" => "from_statuses",
                ],
                [
                    "width" => 3,
                    "name" => "to_status",
                    "type" => "dropdown",
                    "values" => ["'pending'", "'done'"],
                    "valuesName" => "to_statuses",
                ],
            ]
        ]
    ];

return $config;

