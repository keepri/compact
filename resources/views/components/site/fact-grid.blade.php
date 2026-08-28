@props(['cols' => 2, 'as' => 'div'])

@php
    // Class strings must be literal for Tailwind to see them.
    $gridClass = match ((int) $cols) {
        2 => 'md:grid-cols-2',
        3 => 'sm:grid-cols-2 lg:grid-cols-3',
        default => '',
    };
@endphp

<{{ $as }}
    {{ $attributes->class(['border-brand-border bg-brand-border grid gap-px border', $gridClass]) }}>
    {{ $slot }}
    </{{ $as }}>
