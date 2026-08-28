<?php

declare(strict_types=1);

return [
    'name' => env('BRAND_NAME') ?: 'brand.name',
    'colors' => [
        'primary' => env('BRAND_COLOR_PRIMARY') ?: '#000000',
        'primary_hover' => env('BRAND_COLOR_PRIMARY_HOVER') ?: '#333333',
        'secondary' => env('BRAND_COLOR_SECONDARY') ?: '#F5F5F5',
        'accent' => env('BRAND_COLOR_ACCENT') ?: '#000000',
        'background' => env('BRAND_COLOR_BACKGROUND') ?: '#FFFFFF',
        'surface' => env('BRAND_COLOR_SURFACE') ?: '#F5F5F5',
        'surface_hover' => '#EEEEEE',
        'text' => env('BRAND_COLOR_TEXT') ?: '#000000',
        'text_secondary' => '#6b6b6b',
        'text_tertiary' => '#9ca3af',
        'border' => '#E5E5E5',
        'success' => '#2F8F4E',
        'warning' => '#D39E2A',
        'danger' => '#C93B2B',
    ],
    'typography' => [
        'heading' => [
            'family' => env('BRAND_FONT_HEADING') ?: 'Inter',
            'google_font' => true,
            'weights' => [
                0 => 400,
                1 => 500,
                2 => 600,
                3 => 700,
            ],
        ],
        'body' => [
            'family' => env('BRAND_FONT_BODY') ?: 'Inter',
            'google_font' => true,
            'weights' => [
                0 => 400,
                1 => 500,
                2 => 600,
            ],
        ],
    ],
    'assets' => [
        'logo' => [
            'path' => '/branding/logo.png',
            'width' => 150,
            'height' => 50,
            'alt' => 'brand.logo_alt',
        ],
        'logo_dark' => [
            'path' => '/branding/logo-dark.svg',
            'width' => 150,
            'height' => 50,
        ],
        // Additional icons (apple-touch, PNG sizes, manifest, browserconfig) are
        // intentionally not declared - add the keys here and the matching tags in
        // resources/views/components/partials/head.blade.php once the project
        // actually ships those files.
        'favicon' => '/branding/icons/favicon.ico',
        'favicon_svg' => '/branding/icons/favicon.svg',
    ],
];
