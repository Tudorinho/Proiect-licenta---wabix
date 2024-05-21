<?php
$config =
    [
        "routesPrefix" => "leaves",
        "controllerName" => "LeaveController",
        "modelName" => "Leave",
        "translationKeyName" => "leave",
        "translations" => [
            "plural" => "leaves",
            "add" => "addLeave",
            "edit" => "editLeave"
        ],
        "table" => [
            "name" => "leaves",
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
                    "name" => "status",
                    "type" => "enum",
                    "values" => ["'pending'", "'approved'", "'rejected'"],
                    "default" => "'pending'"
                ],
                [
                    "name" => "start_date",
                    "type" => "dateTime"
                ],
                [
                    "name" => "end_date",
                    "type" => "dateTime"
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
                "start_date" => "required",
                "end_date" => "required",
                "status" => "required"
            ],
            "update" => [
                "employee_id" => "required",
                "leaves_types_id" => "required",
                "start_date" => "required",
                "end_date" => "required",
                "status" => "required"
            ],
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
                "name" => "start_date"
            ],
            [
                "name" => "end_date"
            ],
            [
                "name" => "status"
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
                    "name" => "status",
                    "type" => "dropdown",
                    "values" => ["'pending'", "'approved'", "'rejected'"],
                    "valuesName" => "statuses",
                ],
                [
                    "width" => 3,
                    "name" => "start_date",
                    "type" => "datepicker",
                ],
                [
                    "width" => 3,
                    "name" => "end_date",
                    "type" => "datepicker",
                    "marginTop" => 3
                ]
            ]
        ]
    ];

return $config;

