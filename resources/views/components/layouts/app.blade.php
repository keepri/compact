@props(['title' => null])

<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<x-partials.head :title="$title" />

<body class="bg-brand-background text-brand-text flex min-h-screen flex-col">
    <x-partials.header />

    <main class="flex-1">
        {{ $slot ?? '' }}
    </main>

    <x-partials.footer />
    @livewireScripts
</body>

</html>
