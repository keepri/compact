@php
    $contact = config('site.contact', []);
    $locales = \App\Enums\SupportedLocale::cases();
@endphp

<footer class="border-brand-text bg-brand-background border-t-4">
    <div class="bg-brand-primary h-1"></div>

    <div class="mx-auto grid max-w-7xl gap-10 px-6 py-16 md:grid-cols-12">
        <div class="md:col-span-5">
            <p class="font-display text-4xl uppercase">
                {{ __('brand.name') }}<span class="text-brand-primary">.</span>
            </p>
            <p class="font-display mt-4 text-lg uppercase">
                {{ __('site.footer.slogan') }}</p>
            <p class="text-brand-text-secondary mt-2 max-w-xs">
                {{ __('site.footer.tagline') }}
            </p>
        </div>

        <div class="md:col-span-3">
            <p class="eyebrow">{{ __('site.footer.nav_heading') }}</p>
            <div class="text-brand-text-secondary mt-4 flex flex-col gap-2">
                <x-site.nav-links variant="footer" />
            </div>
        </div>

        <div class="md:col-span-4">
            <p class="eyebrow">{{ __('site.footer.contact_heading') }}</p>
            <div class="text-brand-text-secondary mt-4 space-y-2">
                <p>
                    {{ __('site.footer.booking') }}:
                    <a href="mailto:{{ $contact['booking'] }}"
                        class="hover:text-brand-primary transition-colors">{{ $contact['booking'] }}</a>
                </p>
                <p>
                    {{ __('site.footer.press') }}:
                    <a href="mailto:{{ $contact['press'] }}"
                        class="hover:text-brand-primary transition-colors">{{ $contact['press'] }}</a>
                </p>
            </div>
        </div>
    </div>

    <div
        class="border-brand-border text-brand-text-secondary flex flex-col items-center justify-between gap-3 border-t px-6 py-6 text-xs font-semibold uppercase tracking-[0.24em] sm:flex-row">
        <p>&copy; {{ now()->year }} {{ __('brand.name') }}</p>

        <nav class="flex items-center gap-3"
            aria-label="{{ __('site.footer.locale_switch') }}">
            @foreach ($locales as $locale)
                @if (app()->getLocale() === $locale->value)
                    <span class="text-brand-primary"
                        aria-current="true">{{ strtoupper($locale->value) }}</span>
                @else
                    <a href="{{ route('lang.switch', $locale->value) }}"
                        rel="nofollow"
                        class="hover:text-brand-primary transition-colors">{{ strtoupper($locale->value) }}</a>
                @endif
            @endforeach
        </nav>
    </div>
</footer>
