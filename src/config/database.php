<?php
return [
    'mysql' => [
        'driver' => 'mysql',
        'host' => env('DB_HOST', 'localhost2'),
        'database' => env('DB_DATABASE', 'forge2'),
        'username' => env('DB_USERNAME', 'forge2'),
        'password' => env('DB_PASSWORD', 'password123'),
        'charset' => 'utf8',
        'collation' => 'utf8_unicode_ci',
        'prefix' => '',
        'strict' => false,
    ],
];
