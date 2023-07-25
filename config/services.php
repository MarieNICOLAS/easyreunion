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

    'yousign' => [
        'key' => env('YOUSIGN_KEY'),
    ],

    'stripe' => [
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
        'annuaire_monthly_id' => env('STRIPE_ANNUAIRE_MONTHLY'),
        'annuaire_annual_id' => env('STRIPE_ANNUAIRE_ANNUAL'),
    ],

    'sellsy' => [
        'activated' => env('SELLSY_ACTIVATED', true),
        'key' => env('SELLSY_KEY'),
        'secret' => env('SELLSY_SECRET'),
        'redirect_url' => env('SELLSY_REDIRECT_URL')
    ],

    'recaptcha' => [
        'public_key' => env('RECAPTCHA_PUB_KEY'),
        'secret_key' => env('RECAPTCHA_SEC_KEY'),
    ],

];
