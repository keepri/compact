@props(['title' => null])

@php
    $brandName = __('brand.name');

    // Every public page names its lang file after its route, so the meta block
    // is read straight from the route name. Pages without one - the error
    // pages - pass a $title instead and fall back to the site-wide meta.
    $routeKey = request()->route()?->getName();
    $hasPageMeta =
        $routeKey !== null &&
        \Illuminate\Support\Facades\Lang::has("{$routeKey}.meta.title");

    // A page title already reads as a phrase, so it gets the brand appended.
    $documentTitle = match (true) {
        $hasPageMeta => __("{$routeKey}.meta.title") . ' | ' . $brandName,
        (bool) $title => $title . ' | ' . $brandName,
        default => __('site.meta.title'),
    };
    $metaDescription = $hasPageMeta
        ? __("{$routeKey}.meta.description")
        : __('site.meta.description');
    $metaOgTitle = $hasPageMeta
        ? __("{$routeKey}.meta.og_title")
        : $documentTitle;
    $metaOgDescription = $hasPageMeta
        ? __("{$routeKey}.meta.og_description")
        : $metaDescription;
    $metaImage = asset('images/og-compact50.webp');
    $openGraphLocale = \App\Enums\SupportedLocale::from(
        app()->getLocale(),
    )->openGraphLocale();
@endphp

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>{{ $documentTitle }}</title>
    <meta name="description" content="{{ $metaDescription }}">
    <link rel="canonical" href="{{ url()->current() }}">

    <meta property="og:type" content="website">
    <meta property="og:site_name" content="{{ $brandName }}">
    <meta property="og:title" content="{{ $metaOgTitle }}">
    <meta property="og:description" content="{{ $metaOgDescription }}">
    <meta property="og:image" content="{{ $metaImage }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:locale" content="{{ $openGraphLocale }}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $metaOgTitle }}">
    <meta name="twitter:description" content="{{ $metaOgDescription }}">
    <meta name="twitter:image" content="{{ $metaImage }}">

    {{-- The two brand families, declared in resources/css/app.css. --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Archivo+Black&family=Hind:wght@400;500;600;700&display=swap"
        rel="stylesheet">

    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="icon" type="image/png" sizes="32x32"
        href="{{ asset('favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16"
        href="{{ asset('favicon-16x16.png') }}">
    <link rel="apple-touch-icon" sizes="180x180"
        href="{{ asset('apple-touch-icon.png') }}">
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">
    <meta name="theme-color" content="#EFC200">
    <x-partials.structured-data />

    @vite('resources/css/app.css')
    @livewireStyles
</head>
