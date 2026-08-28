@props(['label', 'value' => null, 'note' => null, 'as' => 'div'])

@php
    // /concert renders its event details as a real definition list, so the
    // label/value pair needs to become <dt>/<dd> there.
    [$labelTag, $valueTag] = $as === 'dl' ? ['dt', 'dd'] : ['p', 'p'];
@endphp

<{{ $labelTag }} class="eyebrow">{{ $label }}</{{ $labelTag }}>

    @if (filled($value) || filled($slot->toHtml()))
        <{{ $valueTag }} class="font-display mt-3 text-xl uppercase">
            {{ $value ?? $slot }}
            </{{ $valueTag }}>
    @endif

    @if ($note)
        <p class="text-brand-text-secondary mt-1 text-sm normal-case">
            {{ $note }}</p>
    @endif
