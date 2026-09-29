<?php

declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| Cache Configuration
|--------------------------------------------------------------------------
|
| Only the keys this application overrides live here; the stores, the default
| driver and the prefix come from vendor/laravel/framework/config/cache.php.
|
*/

return [
    /*
     * Default TTL in seconds for cached page content.
     */
    'ttl' => (int) env('CACHE_TTL', 3600),
];
