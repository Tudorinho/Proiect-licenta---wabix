<?php
$config =
[
    "routesPrefix" => "currencies",
    "controllerName" => "CurrencyController",
    "modelName" => "Currency",
    "translationKeyName" => "user",
    "translations" => [
        "plural" => "currencies",
        "add" => "addCurrency",
        "edit" => "editCurrency"
    ],
    "table" => [
        "name" => "currencies"
    ],
    "validators" => [
        "store" => [
            "name" => "required",
            "symbol" => "required"
        ],
        "update" => [
            "name" => "required",
            "symbol" => "required"
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
            "name" => "symbol"
        ],
        [
            "name" => "rate"
        ],
        [
            "name" => "is_default"
        ],
        [
            "name" => "created_at"
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
                "name" => "symbol",
                "type" => "string",
            ],
            [
                "width" => 3,
                "name" => "rate",
                "type" => "string",
            ],
            [
                "width" => 3,
                "name" => "is_default",
                "type" => "dropdown",
                "values" => ["1", "0"],
                "valuesName" => "isDefaultValues",
            ]
        ]
    ]
];

return $config;

