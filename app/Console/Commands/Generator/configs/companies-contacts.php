<?php
$config =
    [
        "routesPrefix" => "companies-contacts",
        "controllerName" => "CompanyContactController",
        "modelName" => "CompanyContact",
        "translationKeyName" => "companyContact",
        "translations" => [
            "plural" => "companiesContacts",
            "add" => "addCompanyContact",
            "edit" => "editCompanyContact"
        ],
        "table" => [
            "name" => "companies_contacts",
            "columns" => [
                [
                    "name" => "id"
                ],
                [
                    "name" => "first_name",
                    "type" => "string",
                ],
                [
                    "name" => "last_name",
                    "type" => "string",
                ],
                [
                    "name" => "email",
                    "type" => "string",
                    "nullable" => true
                ],
                [
                    "name" => "position",
                    "type" => "string",
                    "nullable" => true
                ],
                [
                    "name" => "company_id",
                    "type" => "foreignId",
                ],
                [
                    "name" => "timestamps"
                ]
            ]
        ],
        "relationships" => [
            [
                "column" => "company_id",
                "type" => "belongsTo",
                "name" => "company",
                "relatedModel" => "Company"
            ]
        ],
        "validators" => [
            "store" => [
                "first_name" => "required",
                "last_name" => "required",
                "company_id" => "required"
            ],
            "update" => [
                "first_name" => "required",
                "last_name" => "required",
                "company_id" => "required"
            ],
        ],
        "index" => [
            [
                "name" => "index",
            ],
            [
                "name" => "first_name",
            ],
            [
                "name" => "last_name",
            ],
            [
                "name" => "email",
            ],
            [
                "name" => "position",
            ],
            [
                "name" => "company",
                "value" => "\$row->company->name"
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
                    "name" => "first_name",
                    "type" => "string",
                ],
                [
                    "width" => 3,
                    "name" => "last_name",
                    "type" => "string",
                ],
                [
                    "width" => 3,
                    "name" => "position",
                    "type" => "string",
                ],
                [
                    "width" => 3,
                    "name" => "email",
                    "type" => "string",
                ],
                [
                    "width" => 3,
                    "marginTop" => 3,
                    "name" => "company_id",
                    "type" => "dropdown",
                    "model" => "Company",
                    "valuesName" => "companies",
                    "id" => "id",
                    "displayValue" => "name"
                ]
            ]
        ]
    ];

return $config;

