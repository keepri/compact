<?php

declare(strict_types=1);

use App\Services\BrandingService;

test('branding service exposes config values', function (): void {
    $branding = resolve(BrandingService::class);

    expect($branding->name())->toBeString()
        ->and($branding->color('primary'))->toBeString()
        ->and($branding->colors())->toBeArray();
});
