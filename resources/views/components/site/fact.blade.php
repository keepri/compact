{{-- One cell of an x-site.fact-grid: the hairline grid shows through the gap.
     The value may come from the :value prop or, when it needs markup of its
     own, from the slot. --}}
@props(['label', 'value' => null, 'note' => null, 'media' => null])

<div {{ $attributes->class(['bg-brand-surface p-8']) }}>
    @if ($media)
        <div class="mb-6">{{ $media }}</div>
    @endif

    <p class="eyebrow">{{ $label }}</p>

    @if (filled($value) || filled($slot->toHtml()))
        <p class="font-display mt-3 text-xl uppercase">{{ $value ?? $slot }}</p>
    @endif

    @if ($note)
        <p class="text-brand-text-secondary mt-1 text-sm normal-case">
            {{ $note }}</p>
    @endif
</div>
