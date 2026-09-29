<?php

declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| Database Configuration
|--------------------------------------------------------------------------
|
| The project is PostgreSQL-only in every environment, so the only key worth
| overriding is the default connection. The connection definitions themselves
| come from vendor/laravel/framework/config/database.php.
|
*/

return [
    'default' => env('DB_CONNECTION', 'pgsql'),
];
