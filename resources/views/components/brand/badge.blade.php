@props(['variant' => 'default'])

@php
    $baseClasses =
        'px-2 py-0.5 rounded text-xs font-medium border border-brand-border';
    $variantClasses = match ($variant) {
        'primary' => 'border-brand-primary',
        'success' => 'bg-brand-success text-white border-transparent',
        'warning' => 'bg-brand-warning text-white border-transparent',
        'danger' => 'bg-brand-danger text-white border-transparent',
        default => '',
    };
@endphp

<span {{ $attributes->class([$baseClasses, $variantClasses]) }}>
    {{ $slot }}
</span>
