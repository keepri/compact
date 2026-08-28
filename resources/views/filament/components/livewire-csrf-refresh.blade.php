{{--
    Livewire CSRF auto-refresh for Filament panels.

    Patches window.fetch so that when a Livewire XHR gets a 419 with an
    X-CSRF-TOKEN response header, the token is updated and the request is
    retried transparently — Livewire never sees the 419.

    WHY fetch-patch instead of Livewire's respond hook:
    Livewire's respond() callbacks are called synchronously (forEach), so async
    callbacks are never awaited — Livewire reads mutableObject.response immediately
    and shows the "page expired" confirm() dialog before any retry can complete.
    Patching fetch intercepts at a lower level where we can genuinely await the retry.

    This script is intentionally inline (not a <script src="...">) and placed
    before Livewire boots, so the patch is in place before any Livewire fetch fires.
--}}
<script>
    {!! Vite::content('resources/js/livewire-csrf-refresh.js') !!}
</script>
