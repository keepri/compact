<header x-data="{ open: false }"
    class="border-brand-text bg-brand-background sticky top-0 z-50 border-b-2">
    <div
        class="mx-auto flex h-16 max-w-7xl items-center justify-between gap-6 px-6">
        <a href="{{ route('home') }}"
            class="font-display text-2xl uppercase leading-none tracking-tight">
            {{ __('brand.name') }}<span class="text-brand-primary">.</span>
        </a>

        <nav class="hidden items-center gap-8 md:flex">
            <x-site.nav-links variant="desktop" />
        </nav>

        <button type="button" x-on:click="open = ! open"
            aria-label="{{ __('site.menu') }}" aria-controls="site-mobile-nav"
            :aria-expanded="open" class="text-brand-text md:hidden">
            <svg x-show="open" x-cloak xmlns="http://www.w3.org/2000/svg"
                width="20" height="20" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round" aria-hidden="true">
                <path d="M18 6 6 18" />
                <path d="m6 6 12 12" />
            </svg>
            <svg x-show="! open" xmlns="http://www.w3.org/2000/svg"
                width="20" height="20" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round" aria-hidden="true">
                <path d="M4 12h16" />
                <path d="M4 18h16" />
                <path d="M4 6h16" />
            </svg>
        </button>
    </div>

    <nav id="site-mobile-nav" x-show="open" x-cloak
        class="border-brand-text flex flex-col border-t-2 md:hidden">
        <x-site.nav-links variant="mobile" />
    </nav>
</header>
