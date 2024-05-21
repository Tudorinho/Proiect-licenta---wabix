<?php
$config =
[
    "routesPrefix" => "leaves-types",
    "controllerName" => "LeaveTypeController",
    "modelName" => "LeaveType",
    "translationKeyName" => "leaveType",
    "translations" => [
        "plural" => "leavesTypes",
        "add" => "addLeaveType",
        "edit" => "editLeaveType"
    ],
    "table"=> [
        "name" => "leaves_types",
        "columns" => [
            [
                "name" => "id"
            ],
            [
                "name" => "name",
                "type" => "string"
            ],
            [
                "name" => "is_paid",
                "type" => "boolean"
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
            "name" => "required|max:255",
            "is_paid" => "required",
        ],
        "update" => [
            "name" => "required|max:255",
            "is_paid" => "required"
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
            "name" => "is_paid"
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
                "name" => "is_paid",
                "type" => "dropdown",
                "values" => ["0", "1"],
                "valuesName" => "isPaidValues",
            ]
        ]
    ]
];

return $config;

