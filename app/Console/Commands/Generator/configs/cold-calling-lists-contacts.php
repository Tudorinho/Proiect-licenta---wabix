<?php
$config =
    [
        "routesPrefix" => "cold-calling-lists-contacts",
        "controllerName" => "ColdCallingListsContactsController",
        "modelName" => "ColdCallingListContact",
        "translationKeyName" => "coldCallingListsContacts",
        "translations" => [
            "plural" => "coldCallingListsContacts",
            "add" => "addColdCallingListsContacts",
            "edit" => "editColdCallingListsContacts"
        ],
        "table" => [
            "name" => "cold_calling_lists_contacts",
            "columns" => [
                [
                    "name" => "id"
                ],
                [
                    "name" => "cold_calling_lists_id",
                    "type" => "foreignId",
                ],
                [
                    "name" => "companies_contacts_id",
                    "type" => "foreignId"
                ],
                [
                    "name" => "timestamps"
                ]
            ]
        ],
        "relationships" => [
            [
                "column" => "cold_calling_lists_id",
                "type" => "belongsTo",
                "name" => "coldCallingList",
                "relatedModel" => "ColdCallingList"
            ],
            [
                "column" => "companies_contacts_id",
                "type" => "belongsTo",
                "name" => "companyContact",
                "relatedModel" => "CompanyContact"
            ],
        ],
        "validators" => [
            "store" => [
                "cold_calling_lists_id" => "required",
                "companies_contacts_id" => "required"
            ],
            "update" => [
                "cold_calling_lists_id" => "required",
                "companies_contacts_id" => "required"
            ],
        ],
        "index" => [
            [
                "name" => "index",
            ],
            [
                "name" => "cold_calling_lists_id",
                "value" => "\$row->coldCallingList->name"
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
                    "name" => "cold_calling_lists_id",
                    "type" => "dropdown",
                    "model" => "ColdCallingList",
                    "valuesName" => "coldCallingLists",
                    "id" => "id",
                    "displayValue" => "name"
                ],
                [
                    "width" => 3,
                    "name" => "companies_contacts_id",
                    "type" => "dropdown",
                    "model" => "CompanyContact",
                    "valuesName" => "companyContacts",
                    "id" => "id",
                    "displayValue" => "first_name"
                ]
            ],
        ]
    ];

return $config;

