@php
    $mapEmbed = str_replace(
        ':locale',
        app()->getLocale(),
        (string) config('site.maps.embed'),
    );
    $albums = config('albums', []);
@endphp

<div>
    <x-site.page-header :eyebrow="__('concert.header.eyebrow')" :title="__('concert.header.title')" :intro="__('concert.header.intro')" />

    <x-site.section :eyebrow="__('concert.opening.eyebrow')" :title="__('concert.opening.title')">
        <p class="text-brand-text-secondary max-w-2xl">
            {{ __('concert.opening.description') }}</p>
    </x-site.section>

    <x-site.section :eyebrow="__('concert.albums.eyebrow')" :title="__('concert.albums.title')">
        <p class="text-brand-text-secondary max-w-2xl">
            {{ __('concert.albums.description') }}</p>
    </x-site.section>

    <div class="mx-auto max-w-7xl px-6 py-20">
        <div class="border-brand-text overflow-hidden border-2">
            <img src="{{ asset('images/compact50-landscape.webp') }}"
                alt="{{ __('concert.header.image_alt') }}" width="1920"
                height="1080" class="aspect-video w-full object-cover"
                loading="lazy">
        </div>
        @if (config('site.tickets.url'))
            <div class="mt-12 text-center">
                <x-brand.button :href="config('site.tickets.url')" variant="primary"
                    size="lg" target="_blank" rel="noopener noreferrer">
                    {{ __('concert.details.tickets_value') }} →
                </x-brand.button>
            </div>
        @endif
    </div>

    <x-site.section :eyebrow="__('concert.venue.eyebrow')" :title="__('concert.venue.title')">
        <div class="grid gap-10 lg:grid-cols-12">
            <div class="space-y-5 lg:col-span-4">
                <p class="text-brand-text-secondary">
                    {{ __('concert.venue.paragraph1') }}</p>
                <p class="text-brand-text-secondary">
                    {{ __('concert.venue.paragraph2') }}</p>
            </div>
            <div
                class="border-brand-text bg-brand-surface group aspect-video border-2 lg:col-span-8">
                <iframe src="{{ $mapEmbed }}"
                    title="{{ __('concert.venue.map_title') }}"
                    class="h-full w-full contrast-125 grayscale transition duration-300 group-hover:grayscale-0"
                    loading="lazy"
                    referrerpolicy="strict-origin-when-cross-origin"
                    allowfullscreen></iframe>
            </div>
        </div>
    </x-site.section>

    <x-site.section :eyebrow="__('concert.tracklists.eyebrow')" :title="__('concert.tracklists.title')">
        <div class="grid gap-16 lg:grid-cols-2">
            @foreach ($albums as $i => $album)
                <article wire:key="album-{{ $album['slug'] }}"
                    class="border-brand-border border-l-2 pl-6">
                    <p class="eyebrow">
                        {{ __('concert.albums.album' . ($i + 1) . '.subtitle') }}
                    </p>
                    <h3 class="font-display mt-2 text-2xl uppercase">
                        {{ $album['title'] }}</h3>

                    <dl class="mt-4 grid gap-2 text-sm">
                        <div>
                            <dt class="eyebrow inline">
                                {{ __('concert.albums.composer_label') }}:</dt>
                            <dd class="text-brand-text-secondary ml-1 inline">
                                {{ $album['composer'] }}</dd>
                        </div>
                        <div>
                            <dt class="eyebrow inline">
                                {{ __('concert.albums.studio_label') }}:</dt>
                            <dd class="text-brand-text-secondary ml-1 inline">
                                {{ __('concert.albums.album' . ($i + 1) . '.studio') }}
                            </dd>
                        </div>
                    </dl>

                    <div class="mt-6">
                        <p class="eyebrow">
                            {{ __('concert.albums.tracks_label') }}</p>
                        <ol
                            class="text-brand-text-secondary mt-2 space-y-1 text-sm">
                            @foreach ($album['tracks'] as $track)
                                <li class="flex justify-between gap-4">
                                    <span>
                                        <span
                                            class="text-brand-text/60 tabular-nums">{{ str_pad((string) $track['number'], 2, '0', STR_PAD_LEFT) }}.</span>
                                        {{ $track['title'] }}
                                        @if (!empty($track['instrumental']))
                                            <span
                                                class="text-brand-text/50 italic">({{ __('concert.albums.instrumental') }})</span>
                                        @endif
                                    </span>
                                    <span
                                        class="text-brand-text/60 shrink-0 tabular-nums">{{ $track['duration'] }}</span>
                                </li>
                            @endforeach
                        </ol>
                    </div>

                    <div class="mt-6">
                        <p class="eyebrow">
                            {{ __('concert.albums.guests_label') }}</p>
                        <ul
                            class="text-brand-text-secondary mt-2 space-y-1 text-sm">
                            @foreach ($album['guests'] as $guest)
                                <li>{{ $guest }}</li>
                            @endforeach
                        </ul>
                    </div>
                </article>
            @endforeach
        </div>

        @if (config('site.tickets.url'))
            <div class="mt-12 text-center">
                <x-brand.button :href="config('site.tickets.url')" variant="primary"
                    target="_blank" rel="noopener noreferrer">
                    {{ __('concert.details.tickets_value') }} →
                </x-brand.button>
            </div>
        @endif
    </x-site.section>

    <x-site.section :eyebrow="__('concert.partners.eyebrow')" :title="__('concert.partners.title')">
        <dl class="grid gap-8 md:grid-cols-2">
            <div>
                <dt class="eyebrow">
                    {{ __('concert.partners.organizers_label') }}</dt>
                <dd class="text-brand-text-secondary mt-2">
                    {{ __('concert.partners.organizers') }}</dd>
            </div>
            <div>
                <dt class="eyebrow">
                    {{ __('concert.partners.supporters_label') }}</dt>
                <dd class="text-brand-text-secondary mt-2">
                    {{ __('concert.partners.supporters') }}</dd>
            </div>
            <div>
                <dt class="eyebrow">{{ __('concert.partners.partners_label') }}
                </dt>
                <dd class="text-brand-text-secondary mt-2">
                    {{ __('concert.partners.partners') }}</dd>
            </div>
            <div>
                <dt class="eyebrow">{{ __('concert.partners.media_label') }}
                </dt>
                <dd class="text-brand-text-secondary mt-2">
                    {{ __('concert.partners.media') }}</dd>
            </div>
            <div class="md:col-span-2">
                <dt class="eyebrow">{{ __('concert.partners.producer_label') }}
                </dt>
                <dd class="text-brand-text-secondary mt-2">
                    {{ __('concert.partners.producer') }}</dd>
            </div>
        </dl>
    </x-site.section>
</div>
