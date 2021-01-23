<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => env('SES_REGION', 'us-east-1'),
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\Models\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
        'webhook' => [
            'secret' => env('STRIPE_WEBHOOK_SECRET'),
            'tolerance' => env('STRIPE_WEBHOOK_TOLERANCE', 300),
        ],
    ],

    'dtac' => [
        'base_url' => env('DTAC_BASE_URL'),
        'dob_base_url' => env('DTAC_DOB_BASE_URL'),
        'request_id_prefix' => env('DTAC_REQUEST_ID_PREFIX'),
        'service_key' => env('DTAC_SERVICE_KEY'),
        'service_id' => env('DTAC_SERVICE_ID'),
        'charge_code' => env('DTAC_CHARGE_CODE'),
        'client_id' => env('DTAC_CLIENT_ID'),
        'client_secret' => env('DTAC_CLIENT_SECRET'),
        'ekyc_url' => env('DTAC_EKYC_URL'),
        'dob_uat_charge_amount' => env('DTAC_UAT_CHARGE_AMOUNT'),
        'real_charge_environment' => env('DTAC_REAL_CHARGE_ENVIRONMENT')
    ],

    'tencent' => [
        'cos' => [
            'secret_id' => env('TENCENT_COS_SECRET_ID'),
            'secret_key' => env('TENCENT_COS_SECRET_KEY'),
            'region' => env('TENCENT_COS_REGION'),
            'bucket' => env('TENCENT_COS_BUCKET'),
        ]
    ],

    'xshop' => [
        'base_url' => env('XSHOP_BASE_URL'),
        'api_key' => env('XSHOP_API_KEY'),
        'version' => env('XSHOP_VERSION'),
        'client_id' => env('XSHOP_CLIENT_ID'),
        'key' => env('XSHOP_KEY'),
        'currency' => env('XSHOP_CURRENCY')
    ],

    'conversion' => [
        'baht_to_coin_rate' => env('BAHT_TO_COIN_RATE')
    ]
];
