@php
    $contact = config('site.contact', []);
    $addresses = [
        __('contact.addresses.booking') => $contact['booking'] ?? null,
        __('contact.addresses.press') => $contact['press'] ?? null,
        __('contact.addresses.management') => $contact['management'] ?? null,
    ];
@endphp

<div>
    <x-site.page-header :eyebrow="__('contact.header.eyebrow')" :title="__('contact.header.title')" :intro="__('contact.header.intro')" />

    <x-site.section :eyebrow="__('contact.addresses.eyebrow')" :title="__('contact.addresses.title')">
        <x-site.fact-grid :cols="3">
            @foreach ($addresses as $label => $email)
                <x-site.fact-cell wire:key="address-{{ $loop->index }}">
                    <p class="eyebrow">{{ $label }}</p>
                    <p class="font-display mt-3 uppercase">
                        <a href="mailto:{{ $email }}"
                            class="hover:text-brand-primary transition-colors">{{ $email }}</a>
                    </p>
                </x-site.fact-cell>
            @endforeach
        </x-site.fact-grid>
    </x-site.section>
</div>
