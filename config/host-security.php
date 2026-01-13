<?php
return [
    /*
    |--------------------------------------------------------------------------
    | Domain Protection Enabled
    |--------------------------------------------------------------------------
    |
    | Enable or disable domain protection globally.
    |
    */
    'enabled' => env('DOMAIN_PROTECTION_ENABLED', true),

    /*
    |--------------------------------------------------------------------------
    | Encrypted Domain
    |--------------------------------------------------------------------------
    |
    | The encrypted domain string. You can set this here or in .env
    |
    */
    'encrypted_domain' => env('REGISTERED_DOMAIN_KEY'),

    /*
    |--------------------------------------------------------------------------
    | Allow Empty Domain
    |--------------------------------------------------------------------------
    |
    | Allow the application to run if no domain is registered.
    | Useful for local development.
    |
    */
    'allow_empty' => env('DOMAIN_PROTECTION_ALLOW_EMPTY', false),

    /*
    |--------------------------------------------------------------------------
    | Ignore WWW
    |--------------------------------------------------------------------------
    |
    | Ignore www. prefix when comparing domains.
    |
    */
    'ignore_www' => true,

    /*
    |--------------------------------------------------------------------------
    | Allow Subdomains
    |--------------------------------------------------------------------------
    |
    | Allow subdomains of the registered domain.
    |
    */
    'allow_subdomains' => env('DOMAIN_PROTECTION_ALLOW_SUBDOMAINS', false),

    /*
    |--------------------------------------------------------------------------
    | Error Message
    |--------------------------------------------------------------------------
    |
    | The error message displayed when domain validation fails.
    |
    */
    'error_message' => 'This application is not authorized to run on this domain.',
];
