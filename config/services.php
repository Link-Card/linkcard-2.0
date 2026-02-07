<?php

return [
    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'stripe' => [
        'price_pro_monthly' => env('STRIPE_PRICE_PRO_MONTHLY'),
        'price_pro_yearly' => env('STRIPE_PRICE_PRO_YEARLY'),
        'price_premium_monthly' => env('STRIPE_PRICE_PREMIUM_MONTHLY'),
        'price_premium_yearly' => env('STRIPE_PRICE_PREMIUM_YEARLY'),
    ],

    'referral' => [
        'enabled' => env('REFERRAL_ENABLED', true),
    ],
];
