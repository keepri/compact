<?php

declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| Application Configuration
|--------------------------------------------------------------------------
|
| Only the keys this application overrides live here. Everything else is
| merged in from vendor/laravel/framework/config/app.php at boot, so this
| file never goes stale against the installed framework version.
|
*/

return [
    'name' => env('APP_NAME', 'Boilerplate'),

    // The framework hard-codes UTC; reading it from the environment lets a
    // deployment set its own without editing config.
    'timezone' => env('APP_TIMEZONE', 'UTC'),
];
