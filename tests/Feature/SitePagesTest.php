<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Session;

test('every public page renders', function (string $path): void {
    $this->get($path)->assertOk();
})->with(['/', '/concert', '/formatia', '/contact']);

test('the home page shows the hero and links to the concert', function (): void {
    $response = $this->get('/');

    $response->assertOk()
        ->assertSee(__('home.hero.title_line1'))
        ->assertSee(__('home.hero.lead'))
        ->assertSee(route('concert'));
});

test('each page renders its own header title', function (string $path, string $key): void {
    $this->get($path)->assertOk()->assertSee(__("{$key}.header.title"));
})->with([
    ['/concert', 'concert'],
    ['/formatia', 'band'],
    ['/contact', 'contact'],
]);

test('the band page lists the current lineup and every era', function (): void {
    $response = $this->get('/formatia');

    $response->assertOk()
        ->assertSee('Costi Cămărășan', false)
        ->assertSee(__('band.eras.2026.title'), false);

    foreach (config('band.eras') as $era) {
        $response->assertSee($era['years'], false);
    }
});

test('the contact page shows every address as a mailto link', function (): void {
    $response = $this->get('/contact')->assertOk();

    foreach (config('site.contact') as $email) {
        $response->assertSee('mailto:' . $email, false);
    }
});

test('pages render in romanian by default', function (): void {
    $this->get('/concert')
        ->assertOk()
        ->assertSee('Detalii eveniment', false);
});

test('pages render in english once the locale is switched', function (): void {
    Session::put('locale', 'en');

    $this->get('/concert')
        ->assertOk()
        ->assertSee('Event details', false)
        ->assertDontSee('Detalii eveniment', false);
});

test('the footer offers the other locale', function (): void {
    $this->get('/')
        ->assertOk()
        ->assertSee(route('lang.switch', 'en'));
});

test('the header renders the mobile drawer', function (): void {
    $this->get('/')
        ->assertOk()
        ->assertSee('x-data', false)
        ->assertSee('site-mobile-nav', false);
});
