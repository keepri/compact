<footer
    class="border-brand-border bg-brand-surface text-brand-text border-t pb-8 pt-16">
    <div class="container mx-auto px-6 text-center">
        <x-brand.link href="{{ route('home') }}"
            class="font-display mb-6 inline-block text-2xl font-bold uppercase tracking-tighter">
            <x-brand.name />
        </x-brand.link>

        <p class="text-brand-text-secondary mb-6 text-sm">
            {{ __('footer.rights') }}
        </p>
    </div>
</footer>
