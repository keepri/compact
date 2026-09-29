<?php

declare(strict_types=1);

use App\Models\AdminUser;

/*
|--------------------------------------------------------------------------
| Authentication Configuration
|--------------------------------------------------------------------------
|
| Only the keys this application overrides live here; the framework's own
| config supplies the rest (guards and providers are merged key by key, so
| the stock "web" guard and "users" provider survive alongside these).
|
| The site has a single authenticated surface: the Filament admin panel,
| guarded by "admin". When a project adds a public-facing login, add a "web"
| guard with its own provider and model rather than pointing it at AdminUser.
|
*/

return [
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
];
