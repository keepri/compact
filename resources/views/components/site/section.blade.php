@props(['eyebrow' => null, 'title' => null])

<section {{ $attributes->class(['mx-auto max-w-7xl px-6 py-20']) }}>
    @if ($eyebrow || $title)
        <div
            class="border-brand-text mb-12 flex flex-wrap items-end justify-between gap-4 border-b-2 pb-4">
            <div>
                @if ($eyebrow)
                    <p class="eyebrow">{{ $eyebrow }}</p>
                @endif
                @if ($title)
                    <h2 class="mt-2 text-2xl md:text-3xl">{{ $title }}
                    </h2>
                @endif
            </div>
            <span aria-hidden="true" class="bg-brand-primary h-1 w-28"></span>
        </div>
    @endif

    {{ $slot }}
</section>
