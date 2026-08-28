@props([
    'title' => null,
    'description' => null,
    'ogTitle' => null,
    'ogDescription' => null,
])

@php
    /** @var \App\Services\BrandingService $brandingService */
    $brandingService = app(\App\Services\BrandingService::class);
    $fontUrl = $brandingService->googleFontsUrl();
    $brandName = $brandingService->name();
    $faviconSvg = $brandingService->assetUrl('favicon_svg');
    $faviconIco = $brandingService->assetUrl('favicon');
    $themeColor = $brandingService->color('primary');

    // A page title already reads as a phrase, so it gets the brand appended;
    // with no page title the site-wide one is used verbatim.
    $documentTitle = $title
        ? $title . ' | ' . $brandName
        : __('site.meta.title');
    $metaDescription = $description ?? __('site.meta.description');
    $metaOgTitle = $ogTitle ?? $documentTitle;
    $metaOgDescription = $ogDescription ?? $metaDescription;
@endphp

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>{{ $documentTitle }}</title>
    <meta name="description" content="{{ $metaDescription }}">

    <meta property="og:type" content="website">
    <meta property="og:site_name" content="{{ $brandName }}">
    <meta property="og:title" content="{{ $metaOgTitle }}">
    <meta property="og:description" content="{{ $metaOgDescription }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:locale"
        content="{{ str_replace('-', '_', app()->getLocale()) }}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $metaOgTitle }}">
    <meta name="twitter:description" content="{{ $metaOgDescription }}">

    <!-- Dynamic Google Fonts -->
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
