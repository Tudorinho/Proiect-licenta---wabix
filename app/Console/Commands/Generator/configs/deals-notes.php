<?php
$config =
    [
        "routesPrefix" => "deals-notes",
        "controllerName" => "DealNoteController",
        "modelName" => "DealNote",
        "translationKeyName" => "dealsNotes",
        "translations" => [
            "plural" => "dealsNotes",
            "add" => "addDealNote",
            "edit" => "editDealNote"
        ],
        "table" => [
            "name" => "deals_notes",
            "columns" => [
                [
                    "name" => "id"
                ],
                [
                    "name" => "deals_id",
                    "type" => "foreignId",
                ],
                [
                    "name" => "note",
                    "type" => "text",
                    "nullable" => true
                ],
                [
                    "name" => "timestamps"
                ]
            ]
        ],
        "relationships" => [
            [
                "column" => "deals_id",
                "type" => "belongsTo",
                "name" => "deal",
                "relatedModel" => "Deal"
            ],
        ],
        "validators" => [
            "store" => [
                "deals_id" => "required",
                "note" => "required"
            ],
            "update" => [
                "deals_id" => "required",
                "note" => "required"
            ],
        ],
        "index" => [
            [
                "name" => "index",
            ],
            [
                "name" => "deals_id",
                "value" => "\$row->deal->title"
            ],
            [
                "name" => "note",
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
                    "name" => "deals_id",
                    "type" => "dropdown",
                    "model" => "Deal",
                    "valuesName" => "deals",
                    "id" => "id",
                    "displayValue" => "title"
                ],
                [
                    "width" => 12,
                    "marginTop" => 3,
                    "name" => "note",
                    "type" => "text",
                ]
            ]
        ]
    ];

return $config;

