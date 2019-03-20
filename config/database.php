<?php

return [
    'default' => 'mysql',
    'drivers' => [
        'mysql' => [
            'host' => getenv('DB_HOST')?: 'localhost',
            'port' => getenv('DB_PORT')?: '3306',
            'database' => getenv('DB_DATABASE'),
            'username' => getenv('DB_USER')?:'root',
            'password' => getenv('DB_PASSWORD')?: 'secret',
            'options' => [

            ]
        ],
    ]
];