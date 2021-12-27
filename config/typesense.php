<?php

return [
    'key' => env('TYPESENSE_KEY'),
    'host' => env('TYPESENSE_HOST', 'localhost'),
    'port' => env('TYPESENSE_PORT', '8108'),
    'protocol' => env('TYPESENSE_PROTOCOL', 'http'),
];
