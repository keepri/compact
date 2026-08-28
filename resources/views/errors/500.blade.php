@php
    $errorPage = \App\Models\ErrorPage::get500Page();
    $heading =
        $errorPage?->getTranslation('heading', app()->getLocale()) ??
        __('errors.500.heading');
    $message =
        $errorPage?->getTranslation('message', app()->getLocale()) ??
        __('errors.500.message');
@endphp

<x-layouts.app :title="__('errors.500.title')">
    <main
        class="bg-brand-background text-brand-text flex w-full flex-col items-center justify-center px-6 pb-32 pt-40">
        <div class="container mx-auto text-center">
            <div class="mb-8 select-none">
                <span
                    class="font-display text-brand-primary text-8xl font-bold tracking-tighter md:text-9xl">5</span>
                <span
                    class="font-display text-brand-accent text-8xl font-bold tracking-tighter md:text-9xl">0</span>
                <span
                    class="font-display text-brand-primary text-8xl font-bold tracking-tighter md:text-9xl">0</span>
            </div>

            <h1
                class="font-display text-brand-primary mb-6 text-2xl font-bold uppercase tracking-tight md:text-5xl">
                {!! $heading !!}
            </h1>

            <div
                class="text-brand-text-secondary mx-auto mb-12 max-w-2xl text-lg md:text-xl">
                {!! $message !!}
            </div>

            <div
                class="flex flex-col items-center justify-center gap-4 sm:flex-row">
                <x-brand.button href="{{ route('home') }}" variant="primary"
                    size="lg">
                    {{ __('errors.500.button_home') }}
                </x-brand.button>
            </div>
        </div>
    </main>
</x-layouts.app>
