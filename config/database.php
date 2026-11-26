<?php

declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| Database Configuration
|--------------------------------------------------------------------------
|
| The project is MariaDB-only in every environment (DirectAdmin hosting offers
| nothing else). The connection definitions come from
| vendor/laravel/framework/config/database.php.
|
| Laravel merges each connection as a whole, so the mariadb override starts
| from the framework's own definition and changes one key: the session time
| zone. The app writes timestamps in UTC; without this MariaDB reads them in
| the server's local zone, rejects the hour the clocks skip in March and
| shifts the hour they repeat in October.
|
*/

$framework = require base_path('vendor/laravel/framework/config/database.php');

return [
    'default' => env('DB_CONNECTION', 'mariadb'),

    'connections' => [
        'mariadb' => [...$framework['connections']['mariadb'], 'timezone' => '+00:00'],
    ],
];
