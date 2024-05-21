<?php
$config =
    [
        "routesPrefix" => "holidays",
        "controllerName" => "HolidayController",
        "modelName" => "Holiday",
        "translationKeyName" => "holiday",
        "translations" => [
            "plural" => "holidays",
            "add" => "addHoliday",
            "edit" => "editHoliday"
        ],
        "table" => [
            "name" => "holidays",
            "columns" => [
                [
                    "name" => "id"
                ],
                [
                    "name" => "name",
                    "type" => "string"
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
                    "name" => "timestamps"
                ]
            ]
        ],
        "relationships" => [
        ],
        "validators" => [
            "store" => [
                "name" => "required",
                "start_date" => "required",
                "end_date" => "required"
            ],
            "update" => [
                "name" => "required",
                "start_date" => "required",
                "end_date" => "required"
            ]
        ],
        "index" => [
            [
                "name" => "index",
            ],
            [
                "name" => "name"
            ],
            [
                "name" => "start_date"
            ],
            [
                "name" => "end_date"
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
                ],
                [
                    "width" => 3,
                    "name" => "start_date",
                    "type" => "datepicker",
//                "marginTop" => 3
                ],
                [
                    "width" => 3,
                    "name" => "end_date",
                    "type" => "datepicker",
//                "marginTop" => 3
                ],
            ]
        ]
    ];

return $config;

