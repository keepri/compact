@php
    $lineup = config('band.lineup', []);
    $eras = config('band.eras', []);

    // Read the translated arrays whole: a `note` is legitimately null for most
    // members, and __() would hand back the key rather than null for those.
    $memberText = (array) __('band.members');
    $eraText = (array) __('band.eras');
@endphp

<div>
    <x-site.page-header :eyebrow="__('band.header.eyebrow')" :title="__('band.header.title')" :intro="__('band.header.intro')" />

    <x-site.section :eyebrow="__('band.lineup.eyebrow')" :title="__('band.lineup.title')">
        <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($lineup as $member)
                <article wire:key="member-{{ $member['slug'] }}"
                    class="@if ($loop->even) lg:mt-10 @endif">
                    <div class="border-brand-text overflow-hidden border-2">
                        <img src="{{ asset("images/band/{$member['slug']}.webp") }}"
                            alt="{{ $member['name'] }}" width="800"
                            height="1019"
                            class="aspect-[4/5] w-full object-cover"
                            loading="lazy">
                    </div>
                    <p class="eyebrow mt-3">
                        {{ $memberText[$member['slug']]['role'] ?? '' }}</p>
                    @if (!empty($memberText[$member['slug']]['note']))
                        <p class="text-brand-text-secondary mt-1 text-sm">
                            {{ $memberText[$member['slug']]['note'] }}</p>
                    @endif
                </article>
            @endforeach
        </div>
    </x-site.section>

    <x-site.section :eyebrow="__('band.timeline.eyebrow')" :title="__('band.timeline.title')">
        <div class="space-y-24 md:space-y-32">
            @foreach ($eras as $era)
                <article class="grid gap-x-12 gap-y-32 md:grid-cols-12"
                    wire:key="era-{{ $era['slug'] }}">
                    <div class="md:col-span-3">
                        <p
                            class="font-display @if ($loop->iteration % 3 === 2) text-brand-rust @else text-brand-primary @endif text-xl md:text-2xl">
                            {{ $era['years'] }}</p>
                        @if (!empty($era['photo']))
                            <img src="{{ asset("images/band/{$era['photo']}") }}"
                                alt="{{ $eraText[$era['slug']]['title'] ?? $era['years'] }}"
                                class="border-brand-text bg-brand-secondary mt-5 hidden aspect-square w-full border-2 object-cover md:block"
                                loading="lazy">
                        @else
                            <div aria-hidden="true"
                                class="paper-grain border-brand-text bg-brand-secondary mt-5 hidden aspect-square w-full border-2 md:block">
                            </div>
                        @endif
                    </div>

                    <div
                        class="border-brand-text @unless ($loop->first) border-t-2 @endunless pt-5 md:col-span-9">
                        <h3 class="text-xl md:text-2xl">
                            {{ $eraText[$era['slug']]['title'] ?? '' }}</h3>

                        <div
                            class="mt-6 grid gap-3 sm:grid-cols-[320px_minmax(0,1fr)] md:block">
                            @if (!empty($era['photo']))
                                <img src="{{ asset("images/band/{$era['photo']}") }}"
                                    alt="{{ $eraText[$era['slug']]['title'] ?? $era['years'] }}"
                                    class="border-brand-text bg-brand-secondary aspect-square w-full border-2 object-cover sm:w-[320px] md:hidden"
                                    loading="lazy">
                            @else
                                <div aria-hidden="true"
                                    class="paper-grain border-brand-text bg-brand-secondary aspect-square w-full border-2 sm:w-[320px] md:hidden">
                                </div>
                            @endif
                            <p class="text-brand-text-secondary max-w-2xl">
                                {{ $eraText[$era['slug']]['description'] ?? '' }}
                            </p>
                        </div>

                        @if (!empty($era['founders']))
                            <div class="mt-8">
                                <p class="eyebrow">
                                    {{ __('band.timeline.founders_label') }}
                                </p>
                                <ul class="mt-2 flex flex-wrap gap-2">
                                    @foreach ($era['founders'] as $name)
                                        <li class="text-brand-text/80 text-sm">
                                            {{ $name }}@if (!$loop->last)
                                                ,
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if (!empty($era['lineup']))
                            <div class="mt-8">
                                <p class="eyebrow">
                                    {{ __('band.timeline.lineup_label') }}</p>
                                <ul class="mt-2 flex flex-wrap gap-2">
                                    @foreach ($era['lineup'] as $name)
                                        <li
                                            class="border-brand-border text-brand-text/80 border px-3 py-1 text-sm">
                                            {{ $name }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if (!empty($era['discography']) || !empty($era['hit_songs']))
                            <div class="mt-8">
                                <p class="eyebrow">
                                    {{ __('band.timeline.discography_label') }}
                                </p>
                                @if (!empty($era['discography']))
                                    <ul
                                        class="text-brand-text-secondary mt-2 w-full min-w-0 max-w-full space-y-1 break-all text-sm">
                                        @foreach ($era['discography'] as $album)
                                            <li>{{ $album['year'] }} —
                                                {{ $album['title'] }}
                                                ({{ $album['format'] }})
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                                @if (!empty($era['hit_songs']))
                                    <p
                                        class="text-brand-text-secondary border-brand-border mt-3 flex flex-wrap gap-x-1 border-l-2 pl-3 text-sm">
                                        @foreach ($era['hit_songs'] as $song)
                                            <span>{{ $song }}
                                                @if (!$loop->last)
                                                    ,
                                                @endif
                                            </span>
                                        @endforeach
                                    </p>
                                @endif
                            </div>
                        @endif

                        @if (!empty($era['awards']))
                            <div class="mt-8">
                                <p class="eyebrow">
                                    {{ __('band.timeline.awards_label') }}</p>
                                <ul
                                    class="text-brand-text-secondary mt-2 space-y-1 text-sm">
                                    @foreach ($era['awards'] as $award)
                                        <li>{{ $award['year'] }} —
                                            {{ $award['name'] }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if (!empty($era['international']))
                            <div class="mt-8 max-w-xl">
                                <p class="eyebrow">
                                    {{ __('band.timeline.international_label') }}
                                </p>
                                <ul
                                    class="text-brand-text-secondary mt-2 space-y-1 text-sm">
                                    @foreach ($era['international'] as $event)
                                        <li>{{ $event['year'] }} —
                                            {{ $event['event'] }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif


                    </div>
                </article>
            @endforeach
        </div>
    </x-site.section>

    <x-site.section :eyebrow="__('band.in_memoriam.eyebrow')" :title="__('band.in_memoriam.title')">
        <p class="text-brand-text-secondary max-w-2xl">
            {{ __('band.in_memoriam.text') }}</p>
        <p class="font-display mt-6 text-2xl uppercase">
            {{ __('band.in_memoriam.names') }}</p>
    </x-site.section>
</div>
