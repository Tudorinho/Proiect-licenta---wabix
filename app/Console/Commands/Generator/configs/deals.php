<?php
$config =
    [
        "routesPrefix" => "deals",
        "controllerName" => "DealController",
        "modelName" => "Deal",
        "translationKeyName" => "deal",
        "translations" => [
            "plural" => "deals",
            "add" => "addDeal",
            "edit" => "editDeal"
        ],
        "table" => [
            "name" => "deals",
            "columns" => [
                [
                    "name" => "id"
                ],
                [
                    "name" => "user_id",
                    "type" => "foreignId",
                    "nullable" => true
                ],
                [
                    "name" => "companies_contacts_id",
                    "type" => "foreignId",
                    "nullable" => true
                ],
                [
                    "name" => "emails_threads_messages_id",
                    "type" => "foreignId",
                    "nullable" => true
                ],
                [
                    "name" => "deals_statuses_id",
                    "type" => "foreignId",
                    "nullable" => true
                ],
                [
                    "name" => "deals_sources_id",
                    "type" => "foreignId",
                    "nullable" => true
                ],
                [
                    "name" => "currency_id",
                    "type" => "foreignId",
                    "nullable" => true
                ],
                [
                    "name" => "deal_size",
                    "type" => "decimal",
                    "default" => 0
                ],
                [
                    "name" => "type",
                    "type" => "enum",
                    "values" => ["'new_deal'", "'upsell'"],
                    "default" => "'new_deal'"
                ],
                [
                    "name" => "title",
                    "type" => "string"
                ],
                [
                    "name" => "description",
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
                "column" => "user_id",
                "type" => "belongsTo",
                "name" => "user",
                "relatedModel" => "User"
            ],
            [
                "column" => "companies_contacts_id",
                "type" => "belongsTo",
                "name" => "companyContact",
                "relatedModel" => "CompanyContact"
            ],
            [
                "column" => "emails_threads_messages_id",
                "type" => "belongsTo",
                "name" => "emailThreadMessage",
                "relatedModel" => "EmailThreadMessage"
            ],
            [
                "column" => "deals_statuses_id",
                "type" => "belongsTo",
                "name" => "dealStatus",
                "relatedModel" => "DealStatus"
            ],
            [
                "column" => "deals_sources_id",
                "type" => "belongsTo",
                "name" => "dealSource",
                "relatedModel" => "DealSource"
            ],
            [
                "column" => "currency_id",
                "type" => "belongsTo",
                "name" => "currency",
                "relatedModel" => "Currency"
            ]
        ],
        "validators" => [
            "store" => [
                "deals_statuses_id" => "required",
                "currency_id" => "required",
                "title" => "required",
                "deal_size" => "numeric"
            ],
            "update" => [
                "deals_statuses_id" => "required",
                "currency_id" => "required",
                "title" => "required",
                "deal_size" => "numeric"
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
                "name" => "user_id",
                "value" => "\$row->user->email"
            ],
            [
                "name" => "companies_contacts_id",
                "value" => "\$row->companyContact->first_name.' '.\$row->companyContact->last_name.'('.\$row->companyContact->company->name.')'"
            ],
            [
                "name" => "deals_statuses_id",
                "value" => "\$row->dealStatus->name"
            ],
            [
                "name" => "deals_sources_id",
                "value" => "\$row->dealSource->name"
            ],
            [
                "name" => "currency_id",
                "value" => "\$row->currency->name"
            ],
            [
                "name" => "type",
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
                    "name" => "user_id",
                    "type" => "dropdown",
                    "model" => "User",
                    "valuesName" => "users",
                    "id" => "id",
                    "displayValue" => "email"
                ],
                [
                    "width" => 3,
                    "name" => "companies_contacts_id",
                    "type" => "dropdown",
                    "model" => "CompanyContact",
                    "valuesName" => "companiesContacts",
                    "id" => "id",
                    "displayValue" => "first_name"
                ],
                [
                    "width" => 3,
                    "name" => "deals_statuses_id",
                    "type" => "dropdown",
                    "model" => "DealStatus",
                    "valuesName" => "dealsStatuses",
                    "id" => "id",
                    "displayValue" => "name"
                ],
                [
                    "width" => 3,
                    "name" => "deals_sources_id",
                    "type" => "dropdown",
                    "model" => "DealSource",
                    "valuesName" => "dealsSources",
                    "id" => "id",
                    "displayValue" => "name"
                ],
                [
                    "width" => 2,
                    "marginTop" => 3,
                    "name" => "deal_size",
                    "type" => "string",
                ],
                [
                    "width" => 2,
                    "marginTop" => 3,
                    "name" => "currency_id",
                    "type" => "dropdown",
                    "model" => "Currency",
                    "valuesName" => "currencies",
                    "id" => "id",
                    "displayValue" => "name"
                ],
                [
                    "width" => 2,
                    "marginTop" => 3,
                    "name" => "type",
                    "type" => "dropdown",
                    "values" => ["'new_deal'", "'upsell'"],
                    "valuesName" => "types",
                ],
                [
                    "width" => 6,
                    "marginTop" => 3,
                    "name" => "title",
                    "type" => "string",
                ],
                [
                    "width" => 12,
                    "marginTop" => 3,
                    "name" => "description",
                    "type" => "text",
                ]
            ]
        ]
    ];

return $config;

