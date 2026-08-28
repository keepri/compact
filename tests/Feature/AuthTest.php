<?php

declare(strict_types=1);

use App\Models\AdminUser;

test('the default guard authenticates admin users', function (): void {
    $admin = AdminUser::factory()->create();

    expect(auth()->attempt(['email' => $admin->email, 'password' => 'password']))->toBeTrue()
        ->and(auth()->guard()->user()?->is($admin))->toBeTrue();
});

test('the default guard rejects a wrong password', function (): void {
    $admin = AdminUser::factory()->create();

    expect(auth()->attempt(['email' => $admin->email, 'password' => 'wrong-password']))->toBeFalse()
        ->and(auth()->guard()->check())->toBeFalse();
});
