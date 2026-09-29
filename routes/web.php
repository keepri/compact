<?php

declare(strict_types=1);

use App\Enums\SupportedLocale;
use App\Http\Controllers\SeoController;
use App\Livewire\Pages\Band as BandPage;
use App\Livewire\Pages\Concert as ConcertPage;
use App\Livewire\Pages\Contact as ContactPage;
use App\Livewire\Pages\Home as HomePage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Route;

// Slugs stay Romanian in both locales - the language lives in the session, not
// in the URL, so every page has exactly one address.
Route::get('/', HomePage::class)->name('home');
Route::get('/concert', ConcertPage::class)->name('concert');
Route::get('/formatia', BandPage::class)->name('band');
Route::get('/contact', ContactPage::class)->name('contact');

Route::get('/robots.txt', [SeoController::class, 'robots'])->name('robots');
Route::get('/sitemap.xml', [SeoController::class, 'sitemap'])->name('sitemap');

Route::get('/lang/{locale}', function (string $locale): RedirectResponse {
    $supportedLocale = SupportedLocale::tryFrom($locale);

    abort_unless($supportedLocale !== null, 400);

    session()->put('locale', $supportedLocale->value);

    return back();
})->name('lang.switch');
