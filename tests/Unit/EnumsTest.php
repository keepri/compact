<?php

declare(strict_types=1);

use App\Enums\RoleSlug;
use App\Enums\SupportedLocale;

test('supported locale values returns every case', function (): void {
    expect(SupportedLocale::values())->toBe(['en', 'ro']);
});

test('role slugs are unique', function (): void {
    $values = array_column(RoleSlug::cases(), 'value');

    expect($values)->toBe(array_unique($values));
});
