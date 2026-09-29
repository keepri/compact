{{-- The 404 and 500 pages differ only in their digits and their lang key. The
     heading and message come from the database when the row is there, and fall
     back to nothing rather than to a second copy of the same sentence. --}}
@props(['code'])

@php
    $errorPage = \App\Models\ErrorPage::firstWhere(
        'slug',
        $code === '404' ? 'not_found' : 'error',
    );
    $locale = app()->getLocale();
@endphp

<x-layouts.app :title="__('errors.' . $code . '.title')">
    <main
        class="bg-brand-background text-brand-text flex w-full flex-col items-center justify-center px-6 pb-32 pt-40">
        <div class="mx-auto w-full max-w-7xl text-center">
            <div class="mb-8 select-none">
                @foreach (str_split($code) as $digit)
                    <span
                        class="font-display {{ $loop->iteration === 2 ? 'text-brand-accent' : 'text-brand-primary' }} text-8xl font-bold tracking-tighter md:text-9xl">{{ $digit }}</span>
                @endforeach
            </div>

            <h1
                class="font-display text-brand-primary mb-6 text-2xl font-bold uppercase tracking-tight md:text-5xl">
                {!! $errorPage?->getTranslation('heading', $locale) !!}
            </h1>

            <div
                class="text-brand-text-secondary mx-auto mb-12 max-w-2xl text-lg md:text-xl">
                {!! $errorPage?->getTranslation('message', $locale) !!}
            </div>

            <div
                class="flex flex-col items-center justify-center gap-4 sm:flex-row">
                <x-brand.button href="{{ route('home') }}" variant="primary"
                    size="lg">
                    {{ __("errors.{$code}.button_home") }}
                </x-brand.button>
            </div>
        </div>
    </main>
</x-layouts.app>
