<div>
    <section
        class="border-brand-text relative flex min-h-[calc(100svh-4.125rem)] flex-col justify-end overflow-y-hidden overflow-x-clip border-b-4">
        <div class="absolute inset-x-0 bottom-[25%] top-[8%]">
            <div
                class="relative mx-auto h-full w-full max-w-7xl px-6 md:translate-x-[100px]">
                {{-- The hero is the LCP element: eager, and flagged as the one
                    image worth the first round trip. --}}
                <img src="{{ asset('images/compact-band-diagonal.webp') }}"
                    alt="{{ __('home.hero.image_alt') }}" width="1920"
                    height="1136" loading="eager" fetchpriority="high"
                    class="h-full w-full object-cover object-[100%_0%] max-md:object-[50%_0%]">
                <div
                    class="absolute inset-0 bg-[linear-gradient(to_top,rgba(20,20,20,1)_0%,rgba(20,20,20,0.9)_25%,rgba(20,20,20,0.08)_45%,rgba(20,20,20,0.08)_100%)]">
                </div>
            </div>
        </div>

        <div
            class="relative z-10 mx-auto w-full max-w-7xl px-6 pb-8 md:pb-12 lg:pb-14">
            <div class="max-w-md md:max-w-lg lg:max-w-xl">
                <div
                    class="font-display text-brand-primary inline-block self-start text-[0.625rem] uppercase tracking-[0.14em]">
                    {{ __('home.hero.eyebrow') }}
                </div>

                <h1
                    class="misprint mt-6 text-[2.25rem] leading-[0.9] sm:text-[2.5rem] md:text-[3rem] lg:text-6xl">
                    {{ __('home.hero.title_line1') }}
                    <span class="text-brand-primary block">
                        {{ __('home.hero.title_line2') }}</span>
                    <span
                        class="block">{{ __('home.hero.title_line3') }}</span>
                </h1>

                <div class="border-brand-rust mt-6 max-w-lg border-l-4 pl-5">
                    <p class="text-brand-text/90 text-base md:text-lg">
                        {{ __('home.hero.lead') }}</p>
                </div>
            </div>

            <div class="mt-8 flex flex-wrap gap-4">
                <x-brand.button :href="config('site.tickets.url')" variant="primary"
                    size="lg" target="_blank" rel="noopener noreferrer">
                    {{ __('home.hero.cta_secondary') }} →
                </x-brand.button>
                <x-brand.button :href="route('concert')" variant="outline"
                    size="lg">
                    {{ __('home.hero.cta_primary') }}
                </x-brand.button>
            </div>
        </div>

        <div
            class="border-brand-text bg-brand-background relative z-10 grid shrink-0 grid-cols-2 border-t-2 md:grid-cols-4">
            @foreach ([['label' => __('home.event.date_label'), 'value' => __('home.event.date_value')], ['label' => __('home.event.location_label'), 'value' => __('home.event.location_value'), 'url' => config('site.maps.link')], ['label' => __('home.event.city_label'), 'value' => __('home.event.city_value')], ['label' => __('home.event.tickets_label'), 'value' => __('home.event.tickets_value'), 'url' => config('site.tickets.url')]] as $fact)
                <div
                    class="border-brand-text/60 @if (!$loop->last) md:border-r-2 @endif @if ($loop->odd) border-r-2 @endif @if ($loop->iteration <= 2) border-b-2 md:border-b-0 @endif px-5 py-4 md:px-6 md:py-6">
                    <p class="eyebrow">{{ $fact['label'] }}</p>
                    @if (!empty($fact['url']))
                        <a href="{{ $fact['url'] }}" target="_blank"
                            rel="noopener noreferrer"
                            class="font-display mt-2 inline-block text-base uppercase underline md:text-lg">
                            {{ $fact['value'] }}</a>
                    @else
                        <p
                            class="font-display mt-2 text-base uppercase md:text-lg">
                            {{ $fact['value'] }}</p>
                    @endif
                </div>
            @endforeach
        </div>
    </section>

    <x-site.section :eyebrow="__('home.event.eyebrow')" :title="__('home.event.title')">
        <div class="grid gap-10 md:grid-cols-12 md:items-start">
            <div class="md:col-span-6 md:-mt-4">
                <div class="mb-6 flex items-center gap-6">
                    <div>
                        <p
                            class="font-display text-brand-primary text-3xl md:text-4xl">
                            {{ __('home.event.milestones.start_year') }}</p>
                        <p class="text-brand-text-secondary mt-1 text-sm">
                            {{ __('home.event.milestones.start_text') }}</p>
                    </div>
                    <div aria-hidden="true" class="bg-brand-border h-8 w-px">
                    </div>
                    <div>
                        <p class="font-display text-3xl md:text-4xl">
                            {{ __('home.event.milestones.current_year') }}</p>
                        <p class="text-brand-text-secondary mt-1 text-sm">
                            {{ __('home.event.milestones.current_text') }}</p>
                    </div>
                </div>

                <div class="border-brand-text overflow-hidden border-2">
                    {{-- No aspect class here, so the intrinsic size is what
                        reserves the space and keeps the section from shifting. --}}
                    <img src="{{ asset('images/compact-anniversary.webp') }}"
                        alt="{{ __('home.event.image_alt') }}" width="1600"
                        height="1019" class="w-full object-cover"
                        loading="lazy">
                </div>
            </div>

            <div class="offset-card p-8 md:col-span-6">
                <p class="eyebrow">{{ __('home.event.highlight_venue') }}</p>
                <h3 class="mt-3 text-2xl md:text-3xl">
                    {{ __('home.event.highlight_title') }}</h3>
                <p class="text-brand-text-secondary mt-5">
                    {{ __('home.event.highlight_body') }}</p>
                <a href="{{ route('concert') }}"
                    class="font-display border-brand-text bg-brand-text text-brand-background hover:bg-brand-primary mt-8 inline-block border-2 px-6 py-2.5 text-xs uppercase tracking-[0.14em] transition-colors">
                    {{ __('home.event.highlight_cta') }}
                </a>
            </div>
        </div>
    </x-site.section>

    <section
        class="border-brand-text bg-brand-primary text-brand-background border-y-4">
        <div class="mx-auto max-w-7xl px-6 py-10">
            <p class="font-display text-2xl uppercase leading-snug md:text-4xl">
                {{ __('home.statement.line1') }}
            </p>
            <p class="font-display text-2xl uppercase leading-snug md:text-4xl">
                {{ __('home.statement.line2') }}
            </p>
        </div>
    </section>

    <x-site.section :eyebrow="__('home.about.eyebrow')" :title="__('home.about.title')">
        <div class="grid gap-10 md:grid-cols-12">
            <p class="text-lg md:col-span-7">{{ __('home.about.paragraph1') }}
            </p>
            <div class="md:col-span-5">
                <p class="text-brand-text-secondary">
                    {{ __('home.about.paragraph2') }}</p>
                <a href="{{ route('band') }}"
                    class="font-display border-brand-primary hover:text-brand-primary mt-6 inline-block border-b-4 pb-1 text-sm uppercase">
                    {{ __('home.about.cta') }}
                </a>
            </div>
        </div>
    </x-site.section>
</div>
