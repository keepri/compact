@php
    use App\Services\BrandingService;

    $branding = app(BrandingService::class);
    $asset = $branding->asset('logo');
    $path = $asset['path'] ?? null;
    $alt = $asset['alt'] ?? 'brand.logo_alt';

    // Convert path to proper URL for S3 or local storage
    if ($path) {
        $path = upload_url(ltrim($path, '/'));
    }

    // Check if we're on the login page
$isLoginPage = request()->routeIs('filament.admin.auth.login');

// CSS classes for dark mode support
$classes = 'transition-all duration-200 ease-out';

// In dark mode: invert the logo to make it light
// The dark class will be on a parent element, so we use dark: prefix
$classes .= ' dark:brightness-0 dark:invert';
@endphp

@if ($isLoginPage)
    @if ($path)
        <img src="{{ $path }}" alt="{{ __($alt) }}"
            class="{{ $classes }}"
            style="height: 100%; width: auto; max-width: 200px; object-fit: contain;" />
    @else
        <span class="font-bold dark:text-white">{{ $branding->name() }}</span>
    @endif
@else
    @if ($path)
        <img src="{{ $path }}" alt="{{ __($alt) }}"
            class="{{ $classes }} h-full w-auto object-contain" />
    @else
        <span class="font-bold dark:text-white">{{ $branding->name() }}</span>
    @endif
@endif
