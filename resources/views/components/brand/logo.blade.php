@props(['variant' => 'default'])

@php
    use App\Services\BrandingService;

    $branding = app(BrandingService::class);

    // If variant is 'light', we use the standard logo but apply CSS filters
    // If variant is 'dark', we try to use the specific dark asset
    $assetKey = $variant === 'dark' ? 'logo_dark' : 'logo';
    $asset = $branding->asset($assetKey);

    $path = $asset['path'] ?? null;
    $width = $asset['width'] ?? 150;
    $height = $asset['height'] ?? 50;
    $alt = $asset['alt'] ?? 'brand.logo_alt';

    // Convert path to proper URL for S3 or local storage
    if ($path) {
        $path = upload_url(ltrim($path, '/'));
    }

    $classes =
        $attributes->get('class', '') . ' transition-all duration-200 ease-out';

    // Light: white by default, original on hover. Default: the inverse.
    $classes .=
        $variant === 'light'
            ? ' brightness-0 invert hover:brightness-100 hover:invert-0'
            : ' hover:brightness-0 hover:invert';
@endphp

@if ($path)
    <img src="{{ $path }}" alt="{{ __($alt) }}"
        width="{{ $width }}" height="{{ $height }}"
        {{ $attributes->merge(['class' => $classes]) }} />
@else
    <span class="heading-page" {{ $attributes }}>{{ $branding->name() }}</span>
@endif
