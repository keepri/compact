@props(['name', 'label' => null, 'type' => 'text', 'error' => null])

<div {{ $attributes->only('class') }}>
    @if ($label)
        <label for="{{ $name }}" class="mb-2 block text-sm font-medium">
            {{ $label }}
        </label>
    @endif

    <input type="{{ $type }}" name="{{ $name }}"
        id="{{ $name }}"
        {{ $attributes->except('class')->merge([
            'class' =>
                'w-full bg-brand-secondary/50 border-b focus:border border-brand-border rounded px-4 py-3 pr-8 text-brand-text placeholder-brand-text-tertiary focus:outline-none focus:border-brand-primary',
        ]) }}>

    @if ($error)
        <p class="text-brand-danger mt-1 text-sm">{{ $error }}</p>
    @endif
</div>
