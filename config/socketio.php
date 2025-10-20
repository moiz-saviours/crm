<?php
return [
    'driver' => 'socketio',
    'host' => env('SOCKETIO_HOST', 'localhost'),
    'port' => env('SOCKETIO_PORT', 6001),
    'url' => env('SOCKETIO_URL', env('APP_URL')),
    'namespace' => '\App\Broadcasting',
    'options' => [
        'secure' => env('APP_ENV') === 'production',
    ],
    'path' => env('SOCKETIO_PATH', '/socket.io'),
    'transports' => explode(',', env('SOCKETIO_TRANSPORTS', 'websocket,polling')),
];
