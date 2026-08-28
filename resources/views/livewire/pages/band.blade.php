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
        <x-site.fact-grid :cols="3">
            @foreach ($lineup as $member)
                <x-site.fact-cell wire:key="member-{{ $member['slug'] }}">
                    {{-- Placeholder until the band supplies stage photography. --}}
                    <div
                        class="border-brand-border bg-brand-secondary aspect-square border">
                    </div>
                    <div class="mt-6">
                        <x-site.fact :label="$memberText[$member['slug']]['role'] ?? ''" :value="$member['name']"
                            :note="$memberText[$member['slug']]['note'] ??
                                null" />
                    </div>
                </x-site.fact-cell>
            @endforeach
        </x-site.fact-grid>
    </x-site.section>

    <x-site.section :eyebrow="__('band.timeline.eyebrow')" :title="__('band.timeline.title')">
        <div class="border-brand-border space-y-14 border-l pl-8 md:pl-12">
            @foreach ($eras as $era)
                <article class="relative" wire:key="era-{{ $era['slug'] }}">
                    <span aria-hidden="true"
                        class="bg-brand-primary absolute -left-[38px] top-1.5 h-3 w-3 md:-left-[54px]"></span>
                    <p class="eyebrow">{{ $era['years'] }}</p>
                    <h3 class="mt-2 text-xl md:text-2xl">
                        {{ $eraText[$era['slug']]['title'] ?? '' }}</h3>
                    <p class="text-brand-text-secondary mt-3 max-w-2xl">
                        {{ $eraText[$era['slug']]['description'] ?? '' }}
                    </p>
                    @if (!empty($era['lineup']))
                        <p
                            class="text-brand-text-secondary/80 mt-4 max-w-2xl text-sm">
                            <span
                                class="text-brand-text/70 uppercase tracking-widest">{{ __('band.timeline.lineup_label') }}</span>
                            {{ implode(' · ', $era['lineup']) }}
                        </p>
                    @endif
                </article>
            @endforeach
        </div>
    </x-site.section>
</div>
