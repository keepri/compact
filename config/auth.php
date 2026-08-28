<?php

declare(strict_types=1);

use App\Models\AdminUser;

return [
    /*
    |--------------------------------------------------------------------------
    | Authentication Defaults
    |--------------------------------------------------------------------------
    |
    | The boilerplate ships a single authenticated surface: the Filament admin
    | panel, guarded by "admin". When a project adds a public-facing login, add
    | a "web" guard with its own provider and model here rather than pointing
    | it at AdminUser.
    |
    */

    'defaults' => [
        'guard' => env('AUTH_GUARD', 'admin'),
    ],

    'guards' => [
        'admin' => [
            'driver' => 'session',
            'provider' => 'admins',
        ],
    ],

    'providers' => [
        'admins' => [
            'driver' => 'eloquent',
            'model' => AdminUser::class,
        ],
    ],

    'password_timeout' => env('AUTH_PASSWORD_TIMEOUT', 10800),
];
