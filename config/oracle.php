<?php

return [
    'oracle' => [
        'driver' => 'oracle',
        'host' => env('DB_HOST', ''),
        'port' => env('DB_PORT', '1521'),
        'database' => env('DB_DATABASE', ''),
        'service_name' => env('DB_DATABASE', ''),
        'username' =>  env('DB_USERNAME', ''),
        'password' => env('DB_PASSWORD', ''),
        'charset' => env('DB_CHARSET', ''),
        'prefix' => env('DB_TABLE_PREFIX', ''),
        'tns' => env('DB_TNS', ''),
    ],

    'lat' => [
        'driver' => 'oracle',
        'host' => env('LAT_DB_HOST', ''),
        'port' => env('LAT_DB_PORT', '1521'),
        'database' => env('LAT_DB_DATABASE', ''),
        'service_name' => env('LAT_DB_DATABASE', ''),
        'username' =>  env('LAT_DB_USERNAME', ''),
        'password' => env('LAT_DB_PASSWORD', ''),
        'charset' => env('LAT_DB_CHARSET', ''),
        'prefix' => env('LAT_DB_TABLE_PREFIX', ''),
        'tns' => env('LAT_DB_TNS', ''),
    ],

    'simpeg' => [
        'driver' => 'oracle',
        'host' => env('SIMPEG_DB_HOST', ''),
        'port' => env('SIMPEG_DB_PORT', '1521'),
        'database' => env('SIMPEG_DB_DATABASE', ''),
        'service_name' => env('SIMPEG_DB_DATABASE', ''),
        'username' =>  env('SIMPEG_DB_USERNAME', ''),
        'password' => env('SIMPEG_DB_PASSWORD', ''),
        'charset' => env('SIMPEG_DB_CHARSET', ''),
        'prefix' => env('SIMPEG_DB_TABLE_PREFIX', ''),
        'tns' => env('SIMPEG_DB_TNS', ''),
    ],
];
