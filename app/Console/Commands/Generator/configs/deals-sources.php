<?php
$config =
    [
        "routesPrefix" => "deals-sources",
        "controllerName" => "DealSourceController",
        "modelName" => "DealSource",
        "translationKeyName" => "dealsSources",
        "translations" => [
            "plural" => "dealsSources",
            "add" => "addDealSource",
            "edit" => "editDealSource"
        ],
        "table" => [
            "name" => "deals_sources",
            "columns" => [
                [
                    "name" => "id"
                ],
                [
                    "name" => "name",
                    "type" => "string",
                ],
                [
                    "name" => "is_default",
                    "type" => "boolean",
                    "default" => 0
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
                "name" => "name",
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
            ]
        ]
    ];

return $config;

