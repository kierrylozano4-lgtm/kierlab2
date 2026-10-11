<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Resend, Postmark, AWS, and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'weather' => [
        'api_key' => env('OPENWEATHER_API_KEY'),
        'current_endpoint' => env('OPENWEATHER_CURRENT_ENDPOINT', 'https://api.openweathermap.org/data/2.5/weather'),
        'geocoding_endpoint' => env('OPENWEATHER_GEOCODING_ENDPOINT', 'https://api.openweathermap.org/geo/1.0/direct'),
        'city' => env('WEATHER_CITY', 'Manila'),
        'connect_timeout' => (int) env('WEATHER_CONNECT_TIMEOUT', 3),
        'timeout' => (int) env('WEATHER_TIMEOUT', 5),
        'verify_ssl' => filter_var(env('WEATHER_VERIFY_SSL', true), FILTER_VALIDATE_BOOL),
    ],

];
