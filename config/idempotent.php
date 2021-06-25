<?php

return [
    'forcible' => true,

    'methods' => [
        'POST' => [
            'save' => true, //save the response
            'save_ttl' => 86400 //24 hours
        ],
        'PUT' => [
            'save' => false, //save the response
            'save_ttl' => 0
        ],
        'PATCH' => [
            'save' => false, //save the response
            'save_ttl' => 0
        ]
    ],

    'header_name' => 'Idempotent-Key',

    'back_header_name' => 'Idempotent-Repeated'
];