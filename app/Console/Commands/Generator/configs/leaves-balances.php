<?php
$config =
[
    "routesPrefix" => "leaves-balances",
    "controllerName" => "LeaveBalanceController",
    "modelName" => "LeaveBalance",
    "translationKeyName" => "leaveBalance",
    "translations" => [
        "plural" => "leavesBalances",
        "add" => "addLeaveBalance",
        "edit" => "editLeaveBalance"
    ],
    "table"=> [
        "name" => "leaves_balances",
        "columns" => [
            [
                "name" => "id"
            ],
            [
                "name" => "employee_id",
                "type" => "foreignId",
            ],
            [
                "name" => "leaves_types_id",
                "type" => "foreignId",
            ],
            [
                "name" => "balance",
                "type" => "integer",
                "default" => 0
            ],
            [
                "name" => "year",
                "type" => "string"
            ],
            [
                "name" => "timestamps"
            ]
        ]
    ],
    "relationships" => [
        [
            "column" => "employee_id",
            "type" => "belongsTo",
            "name" => "employee",
            "relatedModel" => "Employee"
        ],
        [
            "column" => "leaves_types_id",
            "type" => "belongsTo",
            "name" => "leaveType",
            "relatedModel" => "LeaveType"
        ],
    ],
    "validators" => [
        "store" => [
            "employee_id" => "required",
            "leaves_types_id" => "required",
            "year" => "required",
        ],
        "update" => [
            "employee_id" => "required",
            "leaves_types_id" => "required",
            "year" => "required",
        ]
    ],
    "index" => [
        [
            "name" => "index",
        ],
        [
            "name" => "employee_id",
            "value" => "\$row->employee->first_name.' '.\$row->employee->last_name"
        ],
        [
            "name" => "leave_type_id",
            "value" => "\$row->leaveType->name"
        ],
        [
            "name" => "balance",
        ],
        [
            "name" => "year",
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
                "name" => "employee_id",
                "type" => "dropdown",
                "model" => "Employee",
                "valuesName" => "employees",
                "id" => "id",
                "displayValue" => "first_name"
            ],
            [
                "width" => 3,
                "name" => "leaves_types_id",
                "type" => "dropdown",
                "model" => "LeaveType",
                "valuesName" => "leavesTypes",
                "id" => "id",
                "displayValue" => "name"
            ],
            [
                "width" => 3,
                "name" => "year",
                "type" => "datepicker",
                "format" => "yyyy"
            ],
            [
                "width" => 3,
                "name" => "balance",
                "type" => "string"
            ],
        ]
    ]
];

return $config;

