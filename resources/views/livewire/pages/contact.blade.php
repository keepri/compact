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
        <div class="grid gap-16 md:grid-cols-3 md:gap-20">
            @foreach ($addresses as $label => $email)
                <div wire:key="address-{{ $loop->index }}"
                    class="@if ($loop->iteration === 2) offset-card-rust @else offset-card @endif p-8">
                    <p class="eyebrow">{{ $label }}</p>
                    <a href="mailto:{{ $email }}"
                        class="font-display hover:text-brand-primary mt-3 block break-all text-lg uppercase">
                        {{ $email }}</a>
                </div>
            @endforeach
        </div>
    </x-site.section>
</div>
