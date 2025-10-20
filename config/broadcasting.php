<?php
return [

    'connections' => [
        'socketio' => [
            'driver' => 'socket.io',
            'host' => env('SOCKETIO_HOST', 'localhost'),
            'port' => env('SOCKETIO_PORT', 6001),
            'namespace' => '\App\Broadcasting',
        ],
    ],
];
