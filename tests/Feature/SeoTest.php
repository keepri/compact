<?php

declare(strict_types=1);

test('robots.txt points at the sitemap and keeps the panel out', function (): void {
    $response = $this->get('/robots.txt')->assertOk();

    expect($response->getContent())
        ->toContain('Sitemap: ' . route('sitemap'))
        ->toContain('Disallow: /admin')
        ->toContain('Disallow: /lang/');
});

test('the sitemap lists every public page', function (): void {
    $response = $this->get('/sitemap.xml')->assertOk();

    $response->assertHeader('Content-Type', 'application/xml');

    foreach (['home', 'concert', 'band'/* , 'contact' */] as $name) {
        $response->assertSee('<loc>' . route($name) . '</loc>', false);
    }
});

test('every public page declares a canonical url', function (string $path): void {
    $this->get($path)
        ->assertOk()
        ->assertSee('<link rel="canonical" href="' . url($path) . '">', false);
})->with(['/', '/concert', '/formatia'/* , '/contact' */]);

test('every public page carries the band structured data', function (string $path): void {
    $this->get($path)
        ->assertOk()
        ->assertSee('application/ld+json', false)
        ->assertSee('{"@context":"https://schema.org"', false)
        ->assertSee('"@type":"MusicGroup"', false);
})->with(['/', '/concert', '/formatia'/* , '/contact' */]);

test('the concert page adds the event structured data', function (): void {
    $this->get('/concert')
        ->assertOk()
        ->assertSee('"@type":"MusicEvent"', false)
        ->assertSee('"startDate":"' . config('site.concert.starts_at') . '"', false)
        ->assertSee(config('site.tickets.url'), false)
        ->assertSee('"streetAddress":"' . config('site.concert.venue.street') . '"', false)
        ->assertSee('"postalCode":"' . config('site.concert.venue.postal_code') . '"', false);
});

test('the event structured data stays off the other pages', function (string $path): void {
    $this->get($path)->assertOk()->assertDontSee('MusicEvent', false);
})->with(['/', '/formatia'/* , '/contact' */]);

test('the locale switch is not crawlable', function (): void {
    $this->get('/')
        ->assertOk()
        ->assertSeeInOrder([
            'href="' . route('lang.switch', 'en') . '"',
            'rel="nofollow"',
        ], false);
});

test('the open graph locale carries a territory', function (): void {
    $this->get('/')
        ->assertOk()
        ->assertSee('property="og:locale" content="ro_RO"', false);
});

test('every rendered image is a webp that exists on disk', function (string $path): void {
    $html = $this->get($path)->assertOk()->getContent();

    preg_match_all('/<img[^>]+src="([^"]+)"/', (string) $html, $matches);

    expect($matches[1])->not->toBeEmpty();

    foreach ($matches[1] as $src) {
        $file = public_path(parse_url($src, PHP_URL_PATH) ?? '');

        expect($src)->toEndWith('.webp')
            ->and(file_exists($file))->toBeTrue("missing image: {$src}");
    }
})->with(['/', '/concert', '/formatia']);

test('only the hero image loads eagerly', function (): void {
    $html = (string) $this->get('/')->assertOk()->getContent();

    preg_match_all('/<img\b[^>]*>/s', $html, $matches);

    $eager = array_filter($matches[0], fn(string $tag): bool => ! str_contains($tag, 'loading="lazy"'));

    expect($eager)->toHaveCount(1)
        ->and($eager[array_key_first($eager)])->toContain('fetchpriority="high"');
});
