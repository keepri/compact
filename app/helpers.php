<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;

if (! function_exists('upload_url')) {
    /**
     * Generate a URL for a file stored on the default filesystem disk.
     *
     * @param string|null $path The file path relative to the disk root
     * @return string The full URL to the file
     */
    function upload_url(?string $path): string
    {
        if (blank($path)) {
            return '';
        }

        // If it's already a full URL, return as-is
        if (str_starts_with($path, 'http')) {
            return $path;
        }

        return Storage::disk(Config::string('filesystems.default'))->url($path);
    }
}
