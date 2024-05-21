<?php
$config =
    [
        "routesPrefix" => "emails-threads-messages",
        "controllerName" => "EmailThreadMessageController",
        "modelName" => "EmailThreadMessage",
        "translationKeyName" => "emailThreadMessage",
        "translations" => [
            "plural" => "emailsThreadsMessages",
            "add" => "addEmailThreadMessage",
            "edit" => "editEmailThreadMessage"
        ],
        "table" => [
            "name" => "emails_threads_messages",
            "columns" => [
                [
                    "name" => "id"
                ],
                [
                    "name" => "emails_threads_id",
                    "type" => "foreignId",
                ],
                [
                    "name" => "subject",
                    "type" => "longText",
                    "nullable" => true
                ],
                [
                    "name" => "message",
                    "type" => "longText",
                    "nullable" => true
                ],
                [
                    "name" => "date",
                    "type" => "datetime",
                    "nullable" => true
                ],
                [
                    "name" => "from",
                    "type" => "string",
                    "nullable" => true
                ],
                [
                    "name" => "to",
                    "type" => "string",
                    "nullable" => true
                ],
                [
                    "name" => "timestamps"
                ]
            ]
        ],
        "relationships" => [
            [
                "column" => "emails_threads_id",
                "type" => "belongsTo",
                "name" => "emailThread",
                "relatedModel" => "EmailThread"
            ]
        ],
        "validators" => [
            "store" => [
                "emails_threads_id" => "required"
            ],
            "update" => [
                "emails_threads_id" => "required"
            ],
        ],
        "index" => [
            [
                "name" => "index",
            ],
            [
                "name" => "subject",
            ],
            [
                "name" => "date",
            ],
            [
                "name" => "from",
            ],
            [
                "name" => "to",
            ],
            [
                "name" => "emails_threads_id",
                "value" => "\$row->emailThread->identifier"
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
                    "name" => "emails_threads_id",
                    "type" => "dropdown",
                    "model" => "EmailThread",
                    "valuesName" => "emailsThreads",
                    "id" => "id",
                    "displayValue" => "identifier"
                ],
                [
                    "width" => 3,
                    "name" => "date",
                    "type" => "datepicker",
                ],
                [
                    "width" => 3,
                    "name" => "from",
                    "type" => "string",
                ],
                [
                    "width" => 3,
                    "name" => "to",
                    "type" => "string",
                ],
                [
                    "width" => 12,
                    "marginTop" => 3,
                    "name" => "subject",
                    "type" => "string",
                ],
                [
                    "width" => 12,
                    "marginTop" => 3,
                    "name" => "message",
                    "type" => "text",
                ]
            ]
        ]
    ];

return $config;

