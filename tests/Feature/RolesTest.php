<?php

declare(strict_types=1);

use App\Enums\RoleSlug;
use App\Models\AdminUser;
use App\Models\Role;
use Database\Seeders\RoleSeeder;

test('seeded roles cover every role slug', function (): void {
    $this->seed(RoleSeeder::class);

    foreach (RoleSlug::cases() as $slug) {
        expect(Role::query()->where('slug', $slug->value)->exists())->toBeTrue();
    }
});

test('an admin user can be assigned a role', function (): void {
    $this->seed(RoleSeeder::class);

    $role = Role::query()->where('slug', RoleSlug::Admin->value)->firstOrFail();
    $user = AdminUser::factory()->create(['role_id' => $role->id]);

    expect($user->role->slug)->toBe(RoleSlug::Admin->value)
        ->and($user->hasRole(RoleSlug::Admin))->toBeTrue()
        ->and($user->hasRole(RoleSlug::Editor))->toBeFalse()
        ->and($role->users)->toHaveCount(1);
});

test('a user without a role is supported', function (): void {
    $user = AdminUser::factory()->create();

    expect($user->role)->toBeNull()
        ->and($user->hasRole(RoleSlug::Admin))->toBeFalse();
});

test('deleting a role detaches it from its users', function (): void {
    $this->seed(RoleSeeder::class);

    $role = Role::query()->where('slug', RoleSlug::Editor->value)->firstOrFail();
    $user = AdminUser::factory()->create(['role_id' => $role->id]);

    $role->delete();

    expect($user->refresh()->role_id)->toBeNull();
});
