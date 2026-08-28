<?php

declare(strict_types=1);

namespace App\Providers\Filament;

use App\Services\BrandingService;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationGroup;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        $branding = resolve(BrandingService::class);

        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->authGuard('admin')
            ->databaseTransactions()
            ->brandLogo(fn(): Factory|View => view('components.brand.admin-logo'))
            ->favicon(fn() => $branding->assetUrl('favicon_svg') ?? $branding->assetUrl('favicon'))
            ->colors($this->getBrandColors($branding))
            ->renderHook(
                'panels::styles.after',
                fn(): Factory|View => view('filament.components.admin-styles'),
            )
            ->renderHook(
                'panels::scripts.after',
                fn(): Factory|View => view('filament.components.livewire-csrf-refresh'),
            )
            ->discoverResources(in: app_path('Filament/Admin/Resources'), for: 'App\Filament\Admin\Resources')
            ->navigationGroups([
                NavigationGroup::make()
                    ->label(fn(): string => __('admin.navigation_groups.content')),
                NavigationGroup::make()
                    ->label(fn(): string => __('admin.navigation_groups.system')),
            ])
            ->discoverPages(in: app_path('Filament/Admin/Pages'), for: 'App\Filament\Admin\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Admin/Widgets'), for: 'App\Filament\Admin\Widgets')
            ->widgets([
                AccountWidget::class,
                FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }

    /**
     * Get brand colors for the Filament panel.
     *
     * @return array<string, array<int|string, int|string>>
     */
    private function getBrandColors(BrandingService $branding): array
    {
        $colors = $branding->colors();

        return [
            'primary' => Color::hex($colors['primary'] ?? '#000000'),
            'success' => Color::hex($colors['success'] ?? '#16a34a'),
            'warning' => Color::hex($colors['warning'] ?? '#ca8a04'),
            'danger' => Color::hex($colors['danger'] ?? '#dc2626'),
        ];
    }
}
