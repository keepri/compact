<?php

declare(strict_types=1);

use App\Models\AdminUser;
use App\Models\ErrorPage;
use Illuminate\Support\Facades\Hash;

test('production seeding creates the error pages and the admin user', function (): void {
    app()->detectEnvironment(fn(): string => 'production');

    $this->artisan('db:seed', ['--force' => true])->assertSuccessful();

    expect(ErrorPage::query()->count())->toBe(2)
        ->and(AdminUser::query()->where('email', config('filament.default_admin_email'))->exists())->toBeTrue();
});

test('seeding again on a later deploy never resets the admin password', function (): void {
    $this->seed();

    $admin = AdminUser::query()->where('email', config('filament.default_admin_email'))->firstOrFail();
    $admin->update(['password' => Hash::make('changed-in-production')]);

    $this->seed();

    expect(AdminUser::query()->count())->toBe(1)
        ->and(Hash::check('changed-in-production', $admin->fresh()->password))->toBeTrue();
});
