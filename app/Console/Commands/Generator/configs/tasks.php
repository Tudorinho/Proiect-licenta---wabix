<?php
$config =
    [
        "routesPrefix" => "tasks",
        "controllerName" => "TaskController",
        "modelName" => "Task",
        "translationKeyName" => "task",
        "translations" => [
            "plural" => "tasks",
            "add" => "addTask",
            "edit" => "editTask"
        ],
        "table" => [
            "name" => "tasks",
            "columns" => [
                [
                    "name" => "id"
                ],
                [
                    "name" => "title",
                    "type" => "string",
                ],
                [
                    "name" => "description",
                    "type" => "text",
                ],
                [
                    "name" => "status",
                    "type" => "enum",
                    "values" => ["'pending'", "'done'"],
                    "default" => "'pending'"
                ],
                [
                    "name" => "priority",
                    "type" => "enum",
                    "values" => ["'low'", "'medium'", "'high'"],
                    "default" => "'low'"
                ],
                [
                    "name" => "due_date",
                    "type" => "dateTime"
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
            ],
        ],
        "validators" => [
            "store" => [
                "title" => "required",
                "description" => "required",
                "status" => "required",
                "priority" => "required",
                "due_date" => "required",
                "user_id" => "required",
                "tasks_lists_id" => "required",
            ],
            "update" => [
                "title" => "required",
                "description" => "required",
                "status" => "required",
                "priority" => "required",
                "due_date" => "required",
                "user_id" => "required",
                "tasks_lists_id" => "required",
            ],
        ],
        "index" => [
            [
                "name" => "index",
            ],
            [
                "name" => "title",
            ],
            [
                "name" => "description",
            ],
            [
                "name" => "status",
            ],
            [
                "name" => "priority",
            ],
            [
                "name" => "due_date"
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
                    "width" => 12,
                    "name" => "title",
                    "type" => "string",
                ],
                [
                    "width" => 12,
                    "marginTop" => 3,
                    "name" => "description",
                    "type" => "text",
                ],
                [
                    "width" => 3,
                    "marginTop" => 3,
                    "name" => "status",
                    "type" => "dropdown",
                    "values" => ["'pending'", "'done'"],
                    "valuesName" => "statuses",
                ],
                [
                    "width" => 3,
                    "marginTop" => 3,
                    "name" => "priority",
                    "type" => "dropdown",
                    "values" => ["'low'", "'medium'", "'high'"],
                    "valuesName" => "priorities",
                ],
                [
                    "width" => 3,
                    "marginTop" => 3,
                    "name" => "due_date",
                    "type" => "datepicker",
                ],
                [
                    "width" => 3,
                    "marginTop" => 3,
                    "name" => "user_id",
                    "type" => "dropdown",
                    "model" => "User",
                    "valuesName" => "users",
                    "id" => "id",
                    "displayValue" => "email"
                ],
                [
                    "width" => 3,
                    "marginTop" => 3,
                    "name" => "tasks_lists_id",
                    "type" => "dropdown",
                    "model" => "TaskList",
                    "valuesName" => "tasksLists",
                    "id" => "id",
                    "displayValue" => "name"
                ],
            ]
        ]
    ];

return $config;

