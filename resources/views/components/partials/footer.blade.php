@php
    $contact = config('site.contact', []);
    $locales = \App\Enums\SupportedLocale::cases();
@endphp

<footer class="border-brand-border bg-brand-surface border-t">
    <div class="mx-auto grid max-w-6xl gap-10 px-6 py-14 md:grid-cols-3">
        <div>
            <p class="font-display text-lg uppercase tracking-[0.3em]">
                <x-brand.name />
            </p>
            <p class="text-brand-text-secondary mt-3 max-w-xs text-sm">
                {{ __('site.footer.tagline') }}
            </p>
        </div>

        <div>
            <p class="eyebrow">{{ __('site.footer.nav_heading') }}</p>
            <div
                class="text-brand-text-secondary mt-4 flex flex-col gap-2 text-sm">
                <x-site.nav-links variant="footer" />
            </div>
        </div>

        <div>
            <p class="eyebrow">{{ __('site.footer.contact_heading') }}</p>
            <div class="text-brand-text-secondary mt-4 space-y-2 text-sm">
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
        class="border-brand-border text-brand-text-secondary flex flex-col items-center justify-between gap-3 border-t px-6 py-6 text-xs uppercase tracking-[0.2em] sm:flex-row">
        <p>&copy; {{ now()->year }} <x-brand.name /></p>

        <nav class="flex items-center gap-3"
            aria-label="{{ __('site.footer.locale_switch') }}">
            @foreach ($locales as $locale)
                @if (app()->getLocale() === $locale->value)
                    <span class="text-brand-primary"
                        aria-current="true">{{ strtoupper($locale->value) }}</span>
                @else
                    <a href="{{ route('lang.switch', $locale->value) }}"
                        class="hover:text-brand-primary transition-colors">{{ strtoupper($locale->value) }}</a>
                @endif
            @endforeach
        </nav>
    </div>
</footer>
