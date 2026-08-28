@props(['cols' => 2])

@php
    // Class strings must be literal for Tailwind to see them.
    $gridClass = match ((int) $cols) {
        3 => 'sm:grid-cols-2 lg:grid-cols-3',
        default => 'md:grid-cols-2',
    };
@endphp

<div
    {{ $attributes->class(['border-brand-border bg-brand-border grid gap-px border', $gridClass]) }}>
    {{ $slot }}
</div>
