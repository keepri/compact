<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Session;

test('locale switch stores supported locale in session', function (): void {
    $response = $this->get('/lang/ro');

    $response->assertRedirect();
    expect(Session::get('locale'))->toBe('ro');
});

test('locale switch rejects unsupported locale', function (): void {
    $response = $this->get('/lang/fr');

    $response->assertBadRequest();
});

test('an unsupported session locale is normalized to the fallback', function (): void {
    Session::put('locale', 'de');

    $this->get('/')->assertOk();

    expect(Session::get('locale'))->toBe(config('app.fallback_locale'));
});
