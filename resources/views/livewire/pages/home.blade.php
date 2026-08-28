<div>
    <section
        class="border-brand-border relative flex min-h-[80vh] items-center overflow-hidden border-b">
        <img src="{{ asset('images/compact-band-diagonal.webp') }}"
            alt="{{ __('home.hero.image_alt') }}" loading="eager"
            class="absolute inset-0 h-full w-full translate-x-[8%] scale-[0.96] object-cover object-[80%_top] md:translate-x-[10%] md:scale-[0.95] md:object-[90%_center]">

        <div
            class="from-brand-background via-brand-background/45 absolute inset-0 bg-gradient-to-r to-transparent">
        </div>
        <div
            class="from-brand-background to-brand-background/25 absolute inset-0 bg-gradient-to-t via-transparent">
        </div>

        <div class="relative z-10 mx-auto w-full max-w-6xl px-6 py-28 md:py-40">
            <p class="eyebrow">{{ __('home.hero.eyebrow') }}</p>
            <h1
                class="mt-6 max-w-3xl text-5xl leading-[0.95] md:text-7xl lg:text-8xl">
                {{ __('home.hero.title_line1') }}
                <span
                    class="text-brand-primary block">{{ __('home.hero.title_line2') }}</span>
            </h1>
            <p class="text-brand-text-secondary mt-8 max-w-xl text-lg">
                {{ __('home.hero.lead') }}
            </p>
            <div class="mt-10 flex flex-wrap gap-4">
                <x-brand.button :href="route('concert')" variant="primary"
                    size="lg">
                    {{ __('home.hero.cta_primary') }}
                </x-brand.button>
                <x-brand.button :href="route('band')" variant="outline"
                    size="lg"
                    class="bg-brand-background/50 backdrop-blur-sm">
                    {{ __('home.hero.cta_secondary') }}
                </x-brand.button>
            </div>
        </div>
    </section>

    <x-site.section :eyebrow="__('home.event.eyebrow')" :title="__('home.event.title')">
        <x-site.fact-grid :cols="3">
            <x-site.fact-cell>
                <x-site.fact :label="__('home.event.date_label')" :value="__('home.event.date_value')" />
            </x-site.fact-cell>
            <x-site.fact-cell>
                <x-site.fact :label="__('home.event.location_label')" :value="__('home.event.location_value')" />
            </x-site.fact-cell>
            <x-site.fact-cell>
                <x-site.fact :label="__('home.event.tickets_label')" :value="__('home.event.tickets_value')" />
            </x-site.fact-cell>
        </x-site.fact-grid>
    </x-site.section>

    <x-site.section :eyebrow="__('home.about.eyebrow')" :title="__('home.about.title')">
        <p class="text-brand-text-secondary max-w-3xl">
            {{ __('home.about.paragraph1') }}</p>
    </x-site.section>
</div>
