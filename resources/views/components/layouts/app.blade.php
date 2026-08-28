@props(['title' => null])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<x-partials.head :title="$title" />

<body class="bg-brand-background text-brand-text flex min-h-screen flex-col">
    <x-partials.header />

    <main class="flex-1">
        {{ $slot ?? '' }}
    </main>

    <x-partials.footer />
    <script>
        {!! Vite::content('resources/js/livewire-csrf-refresh.js') !!}
    </script>
    @livewireScripts
</body>

</html>
