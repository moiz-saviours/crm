<?php
return [

    'connections' => [
        'socketio' => [
            'driver' => 'socketio',
            'host' => env('SOCKETIO_HOST', 'localhost'),
            'port' => env('SOCKETIO_PORT', 6001),
            'url' => env('SOCKETIO_URL', env('APP_URL')),
            'namespace' => '\App\Broadcasting',
            'options' => [
                'secure' => env('APP_ENV') === 'production',
            ],
        ],
    ],
];
