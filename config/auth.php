<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Defaults
    |--------------------------------------------------------------------------
    |
    | This option defines the default authentication "guard" and password
    | reset "broker" for your application. You may change these values
    | as required, but they're a perfect start for most applications.
    |
    */

    'defaults' => [
        'guard' => 'web', // Default guard for regular users
        'passwords' => 'users', // Default password broker for regular users
    ],

    /*
    |--------------------------------------------------------------------------
    | Authentication Guards
    |--------------------------------------------------------------------------
    |
    | Here, we define the various authentication guards for the application.
    | A default configuration has been set which uses session storage and
    | the Eloquent user provider.
    |
    | Supported: "session", "token"
    |
    */

    'guards' => [
        'web' => [ // Regular user guard
            'driver' => 'session',
            'provider' => 'users', // Use the 'users' provider
        ],

        'admin' => [ // Admin guard
            'driver' => 'session',
            'provider' => 'admins', // Use the 'admins' provider
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | User Providers
    |--------------------------------------------------------------------------
    |
    | Every authentication guard requires a user provider, which defines how
    | the users are retrieved out of your database or other storage system.
    |
    | If you have multiple user tables or models, you can configure multiple
    | providers and assign them to your guards.
    |
    | Supported: "database", "eloquent"
    |
    */

    'providers' => [
        'users' => [ // Regular user provider
            'driver' => 'eloquent',
            'model' => App\Models\User::class, // User model for regular users
        ],

        'admins' => [ // Admin provider
            'driver' => 'eloquent',
            'model' => App\Models\Admin::class, // Admin model for admins
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Resetting Passwords
    |--------------------------------------------------------------------------
    |
    | You can specify multiple password reset configurations based on user types.
    |
    */

    'passwords' => [
        'users' => [
            'provider' => 'users', // Password reset for regular users
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],

        'admins' => [
            'provider' => 'admins', // Password reset for admins
            'table' => 'admin_password_reset_tokens', // Custom table for admin password resets
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Password Confirmation Timeout
    |--------------------------------------------------------------------------
    |
    | The amount of time in seconds before a password confirmation expires.
    |
    */

    'password_timeout' => 10800, // 3 hours (default)
];
