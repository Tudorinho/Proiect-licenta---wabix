<?php
$config =
    [
        "routesPrefix" => "companies",
        "controllerName" => "CompanyController",
        "modelName" => "Company",
        "translationKeyName" => "company",
        "translations" => [
            "plural" => "companies",
            "add" => "addCompany",
            "edit" => "editCompany"
        ],
        "table" => [
            "name" => "companies",
            "columns" => [
                [
                    "name" => "id"
                ],
                [
                    "name" => "name",
                    "type" => "string",
                ],
                [
                    "name" => "registration_number",
                    "type" => "string",
                    "nullable" => true
                ],
                [
                    "name" => "address_line_1",
                    "type" => "string",
                    "nullable" => true
                ],
                [
                    "name" => "address_line_2",
                    "type" => "string",
                    "nullable" => true
                ],
                [
                    "name" => "type",
                    "type" => "enum",
                    "values" => ["'lead'", "'prospect'", "'customer'", "'supplier'"],
                    "default" => "'lead'"
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
                "name" => "registration_number",
            ],
            [
                "name" => "type",
            ],
            [
                "name" => "created_at",
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
                    "width" => 4,
                    "name" => "name",
                    "type" => "string"
                ],
                [
                    "width" => 4,
                    "name" => "registration_number",
                    "type" => "string"
                ],
                [
                    "width" => 4,
                    "name" => "type",
                    "type" => "dropdown",
                    "values" => ["'lead'", "'prospect'", "'customer'", "'supplier'"],
                    "valuesName" => "types",
                ],
                [
                    "width" => 6,
                    "marginTop" => 3,
                    "name" => "address_line_1",
                    "type" => "string"
                ],
                [
                    "width" => 6,
                    "marginTop" => 3,
                    "name" => "address_line_2",
                    "type" => "string"
                ]
            ]
        ]
    ];

return $config;

