<?php

declare(strict_types=1);

use App\Filament\Admin\Resources\ErrorPages\Pages\EditErrorPage;
use App\Filament\Admin\Resources\ErrorPages\Pages\ListErrorPages;
use App\Filament\Admin\Resources\Roles\Pages\CreateRole;
use App\Filament\Admin\Resources\Roles\Pages\EditRole;
use App\Filament\Admin\Resources\Roles\Pages\ListRoles;
use App\Filament\Admin\Resources\Users\Pages\CreateUser;
use App\Filament\Admin\Resources\Users\Pages\EditUser;
use App\Filament\Admin\Resources\Users\Pages\ListUsers;
use App\Models\AdminUser;
use App\Models\ErrorPage;
use App\Models\Role;
use Database\Seeders\ErrorPageSeeder;

test('admin login page renders', function (): void {
    $this->get('/admin/login')->assertOk();
});

test('admin dashboard is protected by auth', function (): void {
    $this->get('/admin')->assertRedirect('/admin/login');
});

test('users resource pages render', function (): void {
    $this->actingAs(adminUser(), 'admin');

    Livewire::test(ListUsers::class)->assertOk();
    Livewire::test(CreateUser::class)->assertOk();

    $user = AdminUser::factory()->create();
    Livewire::test(EditUser::class, ['record' => $user->id])->assertOk();
});

test('roles resource pages render', function (): void {
    $this->actingAs(adminUser(), 'admin');

    Livewire::test(ListRoles::class)->assertOk();
    Livewire::test(CreateRole::class)->assertOk();

    $role = Role::factory()->create();
    Livewire::test(EditRole::class, ['record' => $role->id])->assertOk();
});

test('error pages resource pages render', function (): void {
    $this->actingAs(adminUser(), 'admin');
    $this->seed(ErrorPageSeeder::class);

    Livewire::test(ListErrorPages::class)->assertOk();

    $errorPage = ErrorPage::query()->firstOrFail();
    Livewire::test(EditErrorPage::class, ['record' => $errorPage->id])->assertOk();
});

test('the role form saves a translation for every supported locale', function (): void {
    $this->actingAs(adminUser(), 'admin');

    Livewire::test(CreateRole::class)
        ->fillForm([
            'name.en' => 'Reviewer',
            'name.ro' => 'Recenzent',
            'slug' => 'reviewer',
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    $role = Role::query()->where('slug', 'reviewer')->firstOrFail();

    expect($role->getTranslations('name'))->toBe(['en' => 'Reviewer', 'ro' => 'Recenzent']);
});

test('the role form rejects a slug with invalid characters', function (): void {
    $this->actingAs(adminUser(), 'admin');

    Livewire::test(CreateRole::class)
        ->fillForm([
            'name.en' => 'Reviewer',
            'name.ro' => 'Recenzent',
            'slug' => 'Not A Slug!',
        ])
        ->call('create')
        ->assertHasFormErrors(['slug']);
});

test('a user created through the panel is verified by the model hook', function (): void {
    $this->actingAs(adminUser(), 'admin');

    Livewire::test(CreateUser::class)
        ->fillForm([
            'name' => 'Test Admin',
            'email' => 'test-admin@example.com',
            'password' => 'password',
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    expect(AdminUser::query()->where('email', 'test-admin@example.com')->value('email_verified_at'))
        ->not->toBeNull();
});

test('every admin page responds for an authenticated admin', function (string $path): void {
    $this->actingAs(adminUser(), 'admin');

    $this->get($path)->assertOk();
})->with([
    '/admin',
    '/admin/users',
    '/admin/users/create',
    '/admin/roles',
    '/admin/roles/create',
    '/admin/error-pages',
]);
