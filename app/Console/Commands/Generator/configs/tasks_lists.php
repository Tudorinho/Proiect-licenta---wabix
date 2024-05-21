<?php
$config =
    [
        "routesPrefix" => "tasks-lists",
        "controllerName" => "TaskListController",
        "modelName" => "TaskList",
        "translationKeyName" => "taskList",
        "translations" => [
            "plural" => "tasksLists",
            "add" => "addTaskList",
            "edit" => "editTaskList"
        ],
        "table" => [
            "name" => "tasks_lists",
            "columns" => [
                [
                    "name" => "id"
                ],
                [
                    "name" => "name",
                    "type" => "string",
                ],
                [
                    "name" => "timestamps"
                ]
            ]
        ],
        "relationships" => [
            [
                "column" => "task_id",
                "type" => "hasMany",
                "name" => "tasks",
                "relatedModel" => "Task"
            ]
        ],
        "validators" => [
            "store" => [
                "name" => "required"
            ],
            "update" => [
                "name" => "required"
            ],
        ],
        "index" => [
            [
                "name" => "index",
            ],
            [
                "name" => "name"
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
                    "type" => "string",
                ]
            ]
        ]
    ];

return $config;

