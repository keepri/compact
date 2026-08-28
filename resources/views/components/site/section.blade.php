@props(['eyebrow' => null, 'title' => null])

<section {{ $attributes->class(['mx-auto max-w-6xl px-6 py-20']) }}>
    @if ($eyebrow)
        <p class="eyebrow">{{ $eyebrow }}</p>
    @endif
    @if ($title)
        <h2 class="mt-3 text-2xl md:text-3xl">{{ $title }}</h2>
    @endif
    @if ($eyebrow || $title)
        <div class="hairline mb-10 mt-6"></div>
    @endif

    {{ $slot }}
</section>
