@php
    use App\Enums\SupportedLocale;

    // Toggle between the supported locales to demonstrate the /lang/{locale} route
    $currentLocale = app()->getLocale();
    $otherLocale =
        collect(SupportedLocale::values())->first(
            fn(string $locale) => $locale !== $currentLocale,
        ) ?? $currentLocale;
@endphp

<main
    class="bg-brand-background text-brand-text flex min-h-screen flex-col items-center justify-center px-6 py-24">
    <div class="container mx-auto text-center">
        <h1 class="mb-6 text-4xl font-bold md:text-5xl">
            <x-brand.name />
        </h1>

        <p class="text-brand-text-secondary mx-auto mb-12 max-w-2xl text-lg">
            {{ __('welcome.description') }}
        </p>

        <div class="flex flex-col items-center justify-center gap-4 sm:flex-row">
            <x-brand.button href="{{ url('/admin') }}" variant="primary"
                size="lg">
                {{ __('welcome.admin_panel') }}
            </x-brand.button>
            <x-brand.button href="{{ route('lang.switch', $otherLocale) }}"
                variant="outline" size="lg">
                {{ __('welcome.switch_language', ['language' => __('admin.locales.' . $otherLocale)]) }}
            </x-brand.button>
        </div>
    </div>
</main>
