<?php

return [
    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'novaposhta' => [
        'key' => env('NOVAPOSHTA_API_KEY'),
        'cache_hours' => env('NOVAPOSHTA_CACHE_HOURS', 12),
    ],

    'monobank' => [
        'token' => env('MONO_TOKEN'),
        'webhook_secret' => env('MONO_WEBHOOK_SECRET'),
        'mode' => env('MONO_MODE', 'sandbox'),
    ],
];
