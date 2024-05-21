<?php
$config =
    [
        "routesPrefix" => "wiki-categories",
        "controllerName" => "WikiCategoryController",
        "modelName" => "WikiCategory",
        "translationKeyName" => "wikiCategory",
        "translations" => [
            "plural" => "wikiCategories",
            "add" => "addWikiCategory",
            "edit" => "editWikiCategory"
        ],
        "table" => [
            "name" => "wiki_categories",
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

