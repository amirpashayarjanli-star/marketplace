<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
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

    'navasan' => [
        'key' => env('NAVASAN_API_KEY'),
    ],

    'melipayamak' => [
        'username' => env('MELIPAYAMAK_USERNAME'),
        'password' => env('MELIPAYAMAK_PASSWORD'),
        'from'     => env('MELIPAYAMAK_NUMBER'),
    ],

    /*
    | زرین‌پال — شارژ کیف‌پول.
    | مبلغ‌ها همه‌جای سایت تومان است، پس currency را IRT می‌فرستیم.
    | تا وقتی merchant_id خالی باشد، دکمه‌ی شارژ پیام «فعال نیست» می‌دهد.
    */
    'zarinpal' => [
        'merchant_id' => env('ZARINPAL_MERCHANT_ID'),
        'sandbox'     => env('ZARINPAL_SANDBOX', false),
        'min_amount'  => env('ZARINPAL_MIN_AMOUNT', 10000),
        'max_amount'  => env('ZARINPAL_MAX_AMOUNT', 500000000),
    ],


    /*
    | کیف‌پول. حداقل مبلغ برداشت را می‌گذاریم تا درخواست‌های خیلی کوچک
    | که کارمزد انتقالشان بیشتر از خودشان است ثبت نشوند.
    */
    'wallet' => [
        'min_withdrawal' => (int) env('WALLET_MIN_WITHDRAWAL', 100000),
    ],

];