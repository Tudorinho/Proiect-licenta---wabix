<?php
$config =
    [
        "routesPrefix" => "events-types",
        "controllerName" => "EventTypeController",
        "modelName" => "EventType",
        "translationKeyName" => "eventType",
        "translations" => [
            "plural" => "eventsTypes",
            "add" => "addEventType",
            "edit" => "editEventType"
        ],
        "table" => [
            "name" => "events_types",
            "columns" => [
                [
                    "name" => "id"
                ],
                [
                    "name" => "name",
                    "type" => "string",
                ],
                [
                    "name" => "color",
                    "type" => "string",
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
                "name" => "required",
                "color" => "required"
            ],
            "update" => [
                "name" => "required",
                "color" => "required"
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
                "name" => "color",
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
                    "name" => "name",
                    "type" => "string"
                ],
                [
                    "width" => 4,
                    "name" => "color",
                    "type" => "string"
                ]
            ]
        ]
    ];

return $config;

