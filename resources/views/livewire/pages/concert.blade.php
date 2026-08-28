@php
    $details = [
        [
            'label' => __('concert.details.date_label'),
            'value' => __('concert.details.date_value'),
        ],
        [
            'label' => __('concert.details.time_label'),
            'value' => __('concert.details.time_value'),
        ],
        [
            'label' => __('concert.details.location_label'),
            'value' => __('concert.details.location_value'),
        ],
        [
            'label' => __('concert.details.tickets_label'),
            'value' => __('concert.details.tickets_value'),
        ],
    ];
    $program = (array) __('concert.program.items');

    // The venue map embed, with its language parameter pointed at the active
    // locale so the map labels match the rest of the page.
    $mapEmbed = str_replace(
        ':locale',
        app()->getLocale(),
        (string) config('site.maps.embed'),
    );
@endphp

<div>
    <x-site.page-header :eyebrow="__('concert.header.eyebrow')" :title="__('concert.header.title')" :intro="__('concert.header.intro')" />

    <x-site.section :eyebrow="__('concert.details.eyebrow')" :title="__('concert.details.title')">
        {{-- Written out rather than composed from x-site.fact-grid: the event
             details are a real definition list, and a <dl> may only contain
             <dt>/<dd> (optionally wrapped in a <div>). --}}
        <dl
            class="border-brand-border bg-brand-border grid gap-px border md:grid-cols-2">
            @foreach ($details as $detail)
                <x-site.fact-cell wire:key="detail-{{ $loop->index }}">
                    <dt class="eyebrow">{{ $detail['label'] }}</dt>
                    <dd class="font-display mt-3 text-xl uppercase">
                        {{ $detail['value'] }}</dd>
                </x-site.fact-cell>
            @endforeach
        </dl>
    </x-site.section>

    <x-site.section :eyebrow="__('concert.venue.eyebrow')" :title="__('concert.venue.title')">
        <div class="grid gap-8 lg:grid-cols-3">
            <div class="space-y-4 lg:col-span-1">
                <p class="text-brand-text-secondary">
                    {{ __('concert.venue.paragraph1') }}</p>
                <p class="text-brand-text-secondary">
                    {{ __('concert.venue.paragraph2') }}</p>
                <x-brand.button :href="config('site.maps.link')" variant="outline"
                    target="_blank" rel="noopener noreferrer">
                    {{ __('concert.venue.maps_cta') }}
                </x-brand.button>
            </div>
            <div
                class="border-brand-border bg-brand-surface group aspect-video border lg:col-span-2">
                <iframe src="{{ $mapEmbed }}"
                    title="{{ __('concert.venue.map_title') }}"
                    class="h-full w-full contrast-125 grayscale transition duration-300 group-hover:grayscale-0"
                    loading="lazy"
                    referrerpolicy="strict-origin-when-cross-origin"
                    allowfullscreen></iframe>
            </div>
        </div>
    </x-site.section>

    <x-site.section :eyebrow="__('concert.program.eyebrow')" :title="__('concert.program.title')">
        <ol
            class="divide-brand-border border-brand-border bg-brand-surface divide-y border">
            @foreach ($program as $item)
                <li class="flex items-baseline gap-6 p-6"
                    wire:key="program-{{ $loop->index }}">
                    <span class="font-display text-brand-primary">
                        {{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}
                    </span>
                    <span
                        class="font-display uppercase tracking-wide">{{ $item }}</span>
                </li>
            @endforeach
        </ol>
    </x-site.section>
</div>
