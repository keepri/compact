@props([
    'variant' => 'primary',
    'size' => 'default',
    'href' => null,
    'type' => 'button',
    'disabled' => false,
])

@php
    $classes = match ($variant) {
        'outline' => 'btn-outline',
        default => 'btn-primary',
    };

    if ($size === 'lg') {
        $classes .= ' btn-lg';
    }

    $isDisabled = filter_var($disabled, FILTER_VALIDATE_BOOL);
@endphp

@if ($href && !$isDisabled)
    <a href="{{ $href }}" {{ $attributes->class([$classes]) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" @disabled($isDisabled)
        aria-disabled="{{ $isDisabled ? 'true' : 'false' }}"
        {{ $attributes->class([$classes]) }} wire:loading.attr="disabled"
        wire:offline.attr="disabled">
        {{ $slot }}
    </button>
@endif
