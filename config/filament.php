<?php

declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| Filament Configuration
|--------------------------------------------------------------------------
|
| Only the keys this application overrides live here. Everything else is
| merged in from filament/support's own config at boot, so this file never
| goes stale against the installed version - do not publish the full config.
|
| The default admin credentials below are consumed by
| Database\Seeders\FilamentAdminUserSeeder (non-production environments only).
|
*/

return [
    'default_admin_email' => env('FILAMENT_DEFAULT_ADMIN_EMAIL', 'admin@example.com'),
    'default_admin_name' => env('FILAMENT_DEFAULT_ADMIN_NAME', 'Admin User'),
    'default_admin_password' => env('FILAMENT_DEFAULT_ADMIN_PASSWORD', 'password'),
];
