<header
    class="border-brand-border bg-brand-background/95 sticky top-0 z-50 border-b backdrop-blur">
    <div class="mx-auto flex max-w-6xl items-center justify-between px-6 py-5">
        <a href="{{ route('home') }}"
            class="font-display text-xl uppercase tracking-[0.3em]">
            <x-brand.name />
        </a>

        <nav class="hidden items-center gap-8 md:flex">
            <x-site.nav-links variant="desktop" />
        </nav>

        <button type="button" wire:click="toggle" wire:loading.attr="disabled"
            aria-label="{{ __('site.menu') }}" aria-controls="site-mobile-nav"
            aria-expanded="{{ $open ? 'true' : 'false' }}"
            class="text-brand-text disabled:opacity-50 md:hidden">
            @if ($open)
                <svg xmlns="http://www.w3.org/2000/svg" width="20"
                    height="20" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round"
                    aria-hidden="true">
                    <path d="M18 6 6 18" />
                    <path d="m6 6 12 12" />
                </svg>
            @else
                <svg xmlns="http://www.w3.org/2000/svg" width="20"
                    height="20" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round"
                    aria-hidden="true">
                    <path d="M4 12h16" />
                    <path d="M4 18h16" />
                    <path d="M4 6h16" />
                </svg>
            @endif
        </button>
    </div>

    @if ($open)
        <nav id="site-mobile-nav"
            class="border-brand-border flex flex-col border-t md:hidden">
            <x-site.nav-links variant="mobile" />
        </nav>
    @endif
</header>
