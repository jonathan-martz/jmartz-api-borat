<?php
return [
    'driver' => env('MAIL_DRIVER', 'smtp'),
    'host' => env('MAIL_HOST', 'smtp.jmartz.de'),
    'port' => env('MAIL_PORT', 25),
    'from' => [
        'address' => env('MAIL_FROM_ADDRESS', 'borat-mail-bot@jmartz.de'),
        'name' => env('MAIL_FROM_NAME', 'Borat Mail Bot'),
    ],
    'encryption' => env('MAIL_ENCRYPTION', 'tls'),
    'username' => env('MAIL_USERNAME'),
    'password' => env('MAIL_PASSWORD'),
    'sendmail' => '/usr/sbin/sendmail -bs',
    'stream' => [
        'ssl' => [
            'allow_self_signed' => true,
            'verify_peer' => false,
            'verify_peer_name' => false,
        ],
    ],
    'markdown' => [
        'theme' => 'default',
        'paths' => [
            resource_path('views/vendor/mail'),
        ]
    ]
];
