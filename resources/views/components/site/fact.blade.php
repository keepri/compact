@props(['label', 'value' => null, 'note' => null])

<p class="eyebrow">{{ $label }}</p>

@if (filled($value) || filled($slot->toHtml()))
    <p class="font-display mt-3 text-xl uppercase">{{ $value ?? $slot }}</p>
@endif

@if ($note)
    <p class="text-brand-text-secondary mt-1 text-sm normal-case">
        {{ $note }}</p>
@endif
