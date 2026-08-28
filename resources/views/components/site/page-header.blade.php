@props(['eyebrow', 'title', 'intro' => null])

<div
    {{ $attributes->class(['border-brand-border bg-brand-surface border-b']) }}>
    <div class="mx-auto max-w-6xl px-6 py-20">
        <p class="eyebrow">{{ $eyebrow }}</p>
        <h1 class="mt-4 text-4xl md:text-6xl">{{ $title }}</h1>
        @if ($intro)
            <p class="text-brand-text-secondary mt-6 max-w-2xl">
                {{ $intro }}</p>
        @endif
    </div>
</div>
