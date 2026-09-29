<?php

declare(strict_types=1);

use App\Enums\SupportedLocale;

test('supported locale values returns every case', function (): void {
    expect(SupportedLocale::values())->toBe(['en', 'ro']);
});
