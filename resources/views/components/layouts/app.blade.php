@props(['title' => null])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<x-partials.head :title="$title" />

<body>
    {{ $slot ?? '' }}
    <x-partials.footer />
    <script>
        {!! Vite::content('resources/js/livewire-csrf-refresh.js') !!}
    </script>
    @livewireScripts
</body>

</html>
