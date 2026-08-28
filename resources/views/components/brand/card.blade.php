@props([
    'elevated' => false,
    'interactive' => false,
    'variant' => 'default',
])

@php
    $variantClasses = match ($variant) {
        'primary' => 'border-2 border-brand-primary',
        default => 'bg-brand-surface border border-brand-border',
    };

    $baseClasses =
        'p-6 rounded transition duration-150 overflow-hidden ' .
        $variantClasses;
    if ($elevated) {
        $baseClasses .= ' shadow-lg';
    }
    if ($interactive) {
        $baseClasses .=
            ' cursor-pointer hover:border-brand-primary hover:bg-brand-surface-hover';
    }
@endphp

<div {{ $attributes->merge(['class' => $baseClasses]) }}>
    {{ $slot }}
</div>
