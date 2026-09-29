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
            class="font-display {{ $variant === 'mobile' ? 'border-brand-border block border-b px-6 py-4 text-sm' : ($isActive ? 'border-2 border-brand-rust bg-brand-primary px-5 py-2 text-sm text-brand-background' : 'border-2 border-brand-text bg-brand-primary px-5 py-2 text-sm text-brand-background hover:border-brand-rust') }} uppercase tracking-[0.12em] transition-colors">
            {{ $label }}
        </a>
    @else
        <a href="{{ route($item['route']) }}"
            class="{{ $variant === 'mobile' ? 'border-brand-border border-b px-6 py-4 text-sm' : 'text-sm font-semibold tracking-wide' }} text-brand-text-secondary hover:text-brand-text @if ($isActive) text-brand-primary underline decoration-brand-primary decoration-2 underline-offset-4 @endif transition-colors">
            {{ $label }}
        </a>
    @endif
@endforeach
