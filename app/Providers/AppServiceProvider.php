<?php

declare(strict_types=1);

namespace App\Providers;

use App\Enums\SupportedLocale;
use BezhanSalleh\LanguageSwitch\LanguageSwitch;
use Filament\Support\Facades\FilamentTimezone;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Laravel already applies config('app.timezone') to PHP itself; this
        // aligns Filament's date/time display with it.
        FilamentTimezone::set(Config::string('app.timezone'));

        // Force the URL generator to always use APP_URL as the root so URLs
        // stay correct behind tunnels and reverse proxies.
        $appUrl = Config::string('app.url');
        URL::forceRootUrl($appUrl);

        if (str_starts_with($appUrl, 'https://')) {
            URL::forceScheme('https');
        }

        LanguageSwitch::configureUsing(function (LanguageSwitch $switch): void {
            $switch
                ->locales(SupportedLocale::values())
                ->labels([
                    SupportedLocale::En->value => __('admin.locales.en'),
                    SupportedLocale::Ro->value => __('admin.locales.ro'),
                ])
                ->circular()
                ->renderHook('panels::user-menu.after')
                ->visible(insidePanels: true);
        });

        Table::configureUsing(fn(Table $table): Table => $table
            ->defaultPaginationPageOption(25)
            ->persistFiltersInSession()
            ->persistSearchInSession()
            ->persistColumnSearchesInSession()
            ->persistSortInSession());
    }
}
