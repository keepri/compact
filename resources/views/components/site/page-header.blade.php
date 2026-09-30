@props(['eyebrow', 'title', 'intro' => null])

<div
    {{ $attributes->class(['relative overflow-hidden border-b-4 border-brand-text bg-brand-background']) }}>
    <div class="bg-brand-primary absolute left-0 right-0 top-0 h-1"></div>
    <div class="mx-auto max-w-7xl px-6 pb-16 pt-24">
        <div class="grid items-end gap-12 md:grid-cols-12">
            <div class="md:col-span-7">
                <p class="eyebrow">{{ $eyebrow }}</p>
                <h1 class="misprint mt-4 text-3xl md:text-4xl lg:text-5xl">
                    {{ $title }}</h1>
            </div>
            @if ($intro)
                <p
                    class="border-brand-primary text-brand-text-secondary border-l-4 pl-5 md:col-span-5">
                    {{ $intro }}</p>
            @endif
        </div>
    </div>
</div>
