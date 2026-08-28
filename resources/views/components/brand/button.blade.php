@props([
    'variant' => 'primary',
    'size' => 'default',
    'href' => null,
    'type' => 'button',
    'disabled' => false,
    'elevated' => false,
])

@php
    $classes = match ($variant) {
        'outline' => 'btn-outline',
        default => 'btn-primary',
    };

    $sizeClass = match ($size) {
        'sm' => 'btn-sm',
        'lg' => 'btn-lg',
        default => '',
    };

    $fullClasses = trim($classes . ' ' . $sizeClass);

    $isDisabled = filter_var($disabled, FILTER_VALIDATE_BOOL);

    if (filter_var($elevated, FILTER_VALIDATE_BOOL)) {
        $fullClasses .= ' shadow-lg';
    }
@endphp

@if ($href && !$isDisabled)
    <a href="{{ $href }}" {{ $attributes->class([$fullClasses]) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" @disabled($isDisabled)
        aria-disabled="{{ $isDisabled ? 'true' : 'false' }}"
        {{ $attributes->class([$fullClasses]) }} wire:loading.attr="disabled"
        wire:offline.attr="disabled">
        {{ $slot }}
    </button>
@endif
