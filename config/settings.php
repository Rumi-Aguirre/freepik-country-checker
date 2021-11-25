<?php

return [
    'root' => dirname(__DIR__),

    'error' => [
        'display_error_details' => false,
        'log_errors' => true,
        'log_error_details' => true
    ],
    
    'logging' => [
        'name' => 'app',
        'path' => __DIR__ . '/../logs',
        'filename' => 'freepik.log',
        'level' => \Monolog\Logger::DEBUG,
        'file_permission' => 0775,
    ]
];