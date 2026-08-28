@props(['options' => []])

<select {{ $attributes->except('class') }}
    class="{{ $attributes->get('class') }} border-brand-border bg-brand-secondary/50 text-brand-primary focus:border-brand-primary w-full cursor-pointer appearance-none rounded border-b-2 px-4 py-3 pr-4 transition-colors focus:outline-none">
    @foreach ($options as $optionValue => $optionLabel)
        <option value="{{ $optionValue }}">{{ $optionLabel }}</option>
    @endforeach
</select>
