<?php
$config =
    [
        "routesPrefix" => "deals-statuses",
        "controllerName" => "DealStatusController",
        "modelName" => "DealStatus",
        "translationKeyName" => "dealsStatuses",
        "translations" => [
            "plural" => "dealsStatuses",
            "add" => "addDealStatus",
            "edit" => "editDealStatus"
        ],
        "table" => [
            "name" => "deals_statuses",
            "columns" => [
                [
                    "name" => "id"
                ],
                [
                    "name" => "name",
                    "type" => "string",
                ],
                [
                    "name" => "order",
                    "type" => "integer"
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
                "order" => "required",
                "color" => "required"
            ],
            "update" => [
                "name" => "required",
                "order" => "required",
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
                "name" => "order",
            ],
            [
                "name" => "color",
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
                    "name" => "order",
                    "type" => "string",
                ],
                [
                    "width" => 3,
                    "name" => "color",
                    "type" => "string",
                ]
            ]
        ]
    ];

return $config;

