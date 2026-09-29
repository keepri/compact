<?php

declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| Session Configuration
|--------------------------------------------------------------------------
|
| Only the keys this application overrides live here; everything else comes
| from vendor/laravel/framework/config/session.php.
|
*/

return [
    /*
     * The site has no cross-site POST flow, so cookies never need to ride
     * along on a third-party request.
     */
    'same_site' => 'strict',
];
