<?php
$config =
    [
        "routesPrefix" => "emails-threads",
        "controllerName" => "EmailThreadController",
        "modelName" => "EmailThread",
        "translationKeyName" => "emailThread",
        "translations" => [
            "plural" => "emailsThreads",
            "add" => "addEmailThread",
            "edit" => "editEmailThread"
        ],
        "table" => [
            "name" => "emails_threads",
            "columns" => [
                [
                    "name" => "id"
                ],
                [
                    "name" => "identifier",
                    "type" => "string",
                ],
                [
                    "name" => "companies_contacts_id",
                    "type" => "foreignId",
                ],
                [
                    "name" => "timestamps"
                ]
            ]
        ],
        "relationships" => [
            [
                "column" => "companies_contacts_id",
                "type" => "belongsTo",
                "name" => "companyContact",
                "relatedModel" => "CompanyContact"
            ]
        ],
        "validators" => [
            "store" => [
                "identifier" => "required",
                "companies_contacts_id" => "required"
            ],
            "update" => [
                "identifier" => "required",
                "companies_contacts_id" => "required"
            ],
        ],
        "index" => [
            [
                "name" => "index",
            ],
            [
                "name" => "identifier",
            ],
            [
                "name" => "companies_contacts_id",
                "value" => "\$row->companyContact->first_name.' '.\$row->companyContact->last_name"
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
                    "name" => "identifier",
                    "type" => "string",
                ],
                [
                    "width" => 3,
                    "name" => "companies_contacts_id",
                    "type" => "dropdown",
                    "model" => "CompanyContact",
                    "valuesName" => "companiesContacts",
                    "id" => "id",
                    "displayValue" => "first_name"
                ]
            ]
        ]
    ];

return $config;

