<?php

declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| Filesystem Configuration
|--------------------------------------------------------------------------
|
| Only the keys this application overrides live here; the local, public and
| default disks come from vendor/laravel/framework/config/filesystems.php.
| Disks are merged by name, so redefining "s3" replaces that disk whole.
|
*/

return [
    'disks' => [
        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
            // Fail loudly rather than returning false on a write error.
            'throw' => true,
            'report' => false,
            // Bucket policy handles public access - no ACLs needed.
            'visibility' => null,
        ],
    ],
];
