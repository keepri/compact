@props(['variant' => 'desktop'])

@php
    $items = config('site.nav', []);

    // The footer spells the destinations out; the header keeps them short.
    $labelSuffix = $variant === 'footer' ? '_full' : '';
@endphp

@foreach ($items as $item)
    @php
        $isActive = request()->routeIs($item['route']);
        $label = __('site.nav.' . $item['key'] . $labelSuffix);
    @endphp

    @if ($variant === 'footer')
        <a href="{{ route($item['route']) }}"
            class="hover:text-brand-primary @if ($isActive) text-brand-primary @endif transition-colors">
            {{ $label }}
        </a>
    @elseif ($item['cta'])
        <a href="{{ route($item['route']) }}"
            class="font-display {{ $variant === 'mobile' ? 'border-brand-border block border-b px-6 py-4 text-sm' : 'mx-1 text-xs' }} group relative uppercase tracking-[0.2em]">
            @if ($variant === 'desktop')
                <span
                    class="bg-brand-primary/20 absolute -inset-1 rounded-full opacity-0 blur-md transition duration-700 group-hover:opacity-60"></span>
                <span
                    class="border-brand-primary/40 bg-brand-background text-brand-primary group-hover:border-brand-primary @if ($isActive) border-brand-primary bg-brand-primary text-brand-background @endif relative flex items-center rounded-full border px-5 py-2 transition-all duration-300">
                    {{ $label }}
                </span>
            @else
                @if ($isActive)
                    <span
                        class="bg-brand-primary absolute inset-y-4 left-0 w-0.5"></span>
                @endif
                <span class="text-brand-primary">{{ $label }}</span>
            @endif
        </a>
    @else
        <a href="{{ route($item['route']) }}"
            class="font-display text-brand-text-secondary hover:text-brand-primary {{ $variant === 'mobile' ? 'border-brand-border border-b px-6 py-4 text-sm' : 'text-xs' }} @if ($isActive) text-brand-primary @endif uppercase tracking-[0.2em] transition-colors">
            {{ $label }}
        </a>
    @endif
@endforeach
