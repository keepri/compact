<?php

declare(strict_types=1);

return [
    'name' => env('BRAND_NAME') ?: 'brand.name',

    /*
     * Stage black and amp yellow. The hex values are exact sRGB conversions of
     * the oklch palette the site was designed in - do not hand-tune them:
     *   background  oklch(0.13 0 0)       surface     oklch(0.17 0 0)
     *   secondary   oklch(0.22 0 0)       border      oklch(0.27 0 0)
     *   text        oklch(0.96 0.005 90)  primary     oklch(0.83 0.17 92)
     * Filament parses these through Color::hex(), so they must stay hex.
     */
    'colors' => [
        'primary' => env('BRAND_COLOR_PRIMARY') ?: '#EFC200',
        'primary_hover' => env('BRAND_COLOR_PRIMARY_HOVER') ?: '#DEB200',
        'secondary' => env('BRAND_COLOR_SECONDARY') ?: '#1B1B1B',
        'accent' => env('BRAND_COLOR_ACCENT') ?: '#EFC200',
        'background' => env('BRAND_COLOR_BACKGROUND') ?: '#070707',
        'surface' => env('BRAND_COLOR_SURFACE') ?: '#0F0F0F',
        'surface_hover' => '#161616',
        'text' => env('BRAND_COLOR_TEXT') ?: '#F3F2EE',
        'text_secondary' => '#999895',
        'text_tertiary' => '#73716E',
        'border' => '#262626',
        'success' => '#2F8F4E',
        'warning' => '#D39E2A',
        'danger' => '#BE2323',
    ],
    'typography' => [
        'heading' => [
            'family' => env('BRAND_FONT_HEADING') ?: 'Oswald',
            'google_font' => true,
            'weights' => [
                0 => 400,
                1 => 500,
                2 => 600,
                3 => 700,
            ],
        ],
        'body' => [
            'family' => env('BRAND_FONT_BODY') ?: 'Barlow',
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
        // Static build artifacts served straight from public/ - they are not user
        // uploads, so they deliberately bypass upload_url() and the storage disk.
        // Additional icons (apple-touch, PNG sizes, manifest, browserconfig) are
        // intentionally not declared - add the keys here and the matching tags in
        // resources/views/components/partials/head.blade.php once the project
        // actually ships those files.
        'favicon' => '/favicon.ico',
        'favicon_svg' => null,
    ],
];
