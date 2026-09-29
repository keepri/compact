<?php

declare(strict_types=1);

use App\Filament\Admin\Resources\ErrorPages\Pages\EditErrorPage;
use App\Filament\Admin\Resources\ErrorPages\Pages\ListErrorPages;
use App\Models\ErrorPage;
use Database\Seeders\ErrorPageSeeder;

test('admin login page renders', function (): void {
    $this->get('/admin/login')->assertOk();
});

test('admin dashboard is protected by auth', function (): void {
    $this->get('/admin')->assertRedirect('/admin/login');
});

test('error pages resource pages render', function (): void {
    $this->actingAs(adminUser(), 'admin');
    $this->seed(ErrorPageSeeder::class);

    Livewire::test(ListErrorPages::class)->assertOk();

    $errorPage = ErrorPage::query()->firstOrFail();
    Livewire::test(EditErrorPage::class, ['record' => $errorPage->id])->assertOk();
});

test('the error page form saves a translation for every supported locale', function (): void {
    $this->actingAs(adminUser(), 'admin');
    $this->seed(ErrorPageSeeder::class);

    $errorPage = ErrorPage::query()->where('slug', 'not_found')->firstOrFail();

    Livewire::test(EditErrorPage::class, ['record' => $errorPage->id])
        ->fillForm([
            'heading.en' => 'Lost?',
            'heading.ro' => 'Rătăcit?',
        ])
        ->call('save')
        ->assertHasNoFormErrors();

    expect($errorPage->refresh()->getTranslations('heading'))
        ->toBe(['en' => 'Lost?', 'ro' => 'Rătăcit?']);
});
