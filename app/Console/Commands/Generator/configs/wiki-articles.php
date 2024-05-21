<?php
$config =
    [
        "routesPrefix" => "wiki-articles",
        "controllerName" => "WikiArticleController",
        "modelName" => "WikiArticle",
        "translationKeyName" => "wikiArticle",
        "translations" => [
            "plural" => "wikiArticles",
            "add" => "addWikiArticle",
            "edit" => "editWikiArticle"
        ],
        "table" => [
            "name" => "wiki_articles",
            "columns" => [
                [
                    "name" => "id"
                ],
                [
                    "name" => "title",
                    "type" => "string",
                ],
                [
                    "name" => "body",
                    "type" => "longText",
                ],
                [
                    "name" => "wiki_categories_id",
                    "type" => "foreignId",
                ],
                [
                    "name" => "timestamps"
                ]
            ]
        ],
        "relationships" => [
            [
                "column" => "wiki_categories_id",
                "type" => "belongsTo",
                "name" => "wikiCategory",
                "relatedModel" => "WikiCategory"
            ],
        ],
        "validators" => [
            "store" => [
                "title" => "required",
                "body" => "required",
                "wiki_categories_id" => "required",
            ],
            "update" => [
                "title" => "required",
                "body" => "required",
                "wiki_categories_id" => "required",
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
                "name" => "wiki_categories_id",
                "value" => "\$row->wikiCategory->name"
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
                    "name" => "title",
                    "type" => "string"
                ],
                [
                    "width" => 3,
                    "marginTop" => 3,
                    "name" => "wiki_categories_id",
                    "type" => "dropdown",
                    "model" => "WikiCategory",
                    "valuesName" => "wikiCategories",
                    "id" => "id",
                    "displayValue" => "name"
                ],
                [
                    "width" => 12,
                    "marginTop" => 3,
                    "name" => "body",
                    "type" => "text"
                ],
            ]
        ]
    ];

return $config;

