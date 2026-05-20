<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
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

    'evotor' => [
    'api_url' => env('EVOTOR_API_URL', 'https://api.evotor.ru'),
    'api_key' => env('EVOTOR_API_KEY'),
    'oauth_url' => env('EVOTOR_OAUTH_URL', 'https://api.evotor.ru/oauth/token'),
    'client_id' => env('EVOTOR_CLIENT_ID'),
    'client_secret' => env('EVOTOR_CLIENT_SECRET'),
    'store_uuid' => env('EVOTOR_STORE_UUID'),
    'webhook_token' => env('EVOTOR_WEBHOOK_TOKEN'),
],

'komtet' => [
    'shop_id' => env('KOMTET_SHOP_ID'),
    'secret' => env('KOMTET_SECRET'),
    'queue_id' => env('KOMTET_QUEUE_ID'),
], 

];
