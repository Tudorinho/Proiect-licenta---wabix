<?php
$config =
    [
        "routesPrefix" => "events",
        "controllerName" => "EventController",
        "modelName" => "Event",
        "translationKeyName" => "event",
        "translations" => [
            "plural" => "events",
            "add" => "addEvent",
            "edit" => "editEvent"
        ],
        "table" => [
            "name" => "events",
            "columns" => [
                [
                    "name" => "id"
                ],
                [
                    "name" => "name",
                    "type" => "string",
                ],
                [
                    "name" => "start_date",
                    "type" => "dateTime"
                ],
                [
                    "name" => "end_date",
                    "type" => "dateTime"
                ],
                [
                    "name" => "events_types_id",
                    "type" => "foreignId"
                ],
                [
                    "name" => "timestamps"
                ]
            ]
        ],
        "relationships" => [
            [
                "column" => "events_types_id",
                "type" => "belongsTo",
                "name" => "eventType",
                "relatedModel" => "EventType"
            ],
        ],
        "validators" => [
            "store" => [
                "name" => "required",
                "start_date" => "required",
                "end_date" => "required",
                "events_types_id" => "required",
            ],
            "update" => [
                "name" => "required",
                "start_date" => "required",
                "end_date" => "required",
                "events_types_id" => "required",
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
                "name" => "events_types_id",
                "value" => "\$row->eventType->name"
            ],
            [
                "name" => "start_date",
            ],
            [
                "name" => "end_date",
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
                    "name" => "start_date",
                    "type" => "datepicker",
                ],
                [
                    "width" => 3,
                    "name" => "end_date",
                    "type" => "datepicker",
                ],
                [
                    "width" => 3,
                    "name" => "events_types_id",
                    "type" => "dropdown",
                    "model" => "EventType",
                    "valuesName" => "eventsTypes",
                    "id" => "id",
                    "displayValue" => "name"
                ],
            ]
        ]
    ];

return $config;

