<?php

declare(strict_types=1);

use App\Enums\SupportedLocale;
use App\Livewire\Pages\Welcome as WelcomePage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Route;

Route::get('/', WelcomePage::class)->name('home');

Route::get('/lang/{locale}', function (string $locale): RedirectResponse {
    $supportedLocale = SupportedLocale::tryFrom($locale);

    abort_unless($supportedLocale !== null, 400);

    session()->put('locale', $supportedLocale->value);

    return back();
})->name('lang.switch');
