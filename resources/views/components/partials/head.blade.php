<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>
        {{ isset($title) ? $title . ' | ' . config('app.name') : config('app.name') }}
    </title>

    <!-- Dynamic Google Fonts -->
    @php
        /** @var \App\Services\BrandingService $brandingService */
        $brandingService = app(\App\Services\BrandingService::class);
        $fontUrl = $brandingService->googleFontsUrl();
        $brandName = $brandingService->name();
        $faviconSvg = $brandingService->assetUrl('favicon_svg');
        $faviconIco = $brandingService->assetUrl('favicon');
        $themeColor = $brandingService->color('primary');
    @endphp
    @if ($fontUrl)
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="{{ $fontUrl }}" rel="stylesheet">
    @endif

    @if ($faviconSvg)
        <link rel="icon" type="image/svg+xml" href="{{ $faviconSvg }}">
    @endif
    @if ($faviconIco)
        <link rel="icon" type="image/x-icon" href="{{ $faviconIco }}">
        <link rel="shortcut icon" href="{{ $faviconIco }}">
    @endif
    <meta name="application-name" content="{{ $brandName }}">
    <meta name="apple-mobile-web-app-title" content="{{ $brandName }}">
    <meta name="theme-color" content="{{ $themeColor }}">
    @vite(['resources/css/app.css', 'resources/js/app.jsx'])
    <x-partials.branding-styles />
    @livewireStyles
</head>
