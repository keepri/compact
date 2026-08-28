<?php

declare(strict_types=1);

use App\Models\ErrorPage;
use Database\Seeders\ErrorPageSeeder;

test('seeded error pages contain both locales', function (): void {
    $this->seed(ErrorPageSeeder::class);

    $notFound = ErrorPage::query()->where('slug', 'not_found')->first();
    $error = ErrorPage::query()->where('slug', 'error')->first();

    expect($notFound)->not->toBeNull()
        ->and($error)->not->toBeNull()
        ->and($notFound->getTranslations('heading'))->toHaveKeys(['en', 'ro'])
        ->and($error->getTranslations('heading'))->toHaveKeys(['en', 'ro']);
});

test('404 page uses customized error page content', function (): void {
    $this->seed(ErrorPageSeeder::class);

    $headings = ['en' => 'Custom 404', 'ro' => '404 Personalizat'];

    ErrorPage::query()->where('slug', 'not_found')->update(['heading' => $headings]);

    $this->get('/nonexistent-page')
        ->assertNotFound()
        ->assertSee($headings[app()->getLocale()], false);
});

test('saving an error page invalidates its cached content', function (): void {
    $this->seed(ErrorPageSeeder::class);

    $this->get('/nonexistent-page')->assertNotFound();

    ErrorPage::query()
        ->where('slug', 'not_found')
        ->firstOrFail()
        ->setTranslation('heading', app()->getLocale(), 'Refreshed 404')
        ->save();

    $this->get('/nonexistent-page')->assertNotFound()->assertSee('Refreshed 404');
});
