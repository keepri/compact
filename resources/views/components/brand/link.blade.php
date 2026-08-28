@props(['href', 'underline' => false])

<a href="{{ $href }}"
    {{ $attributes->class(['link-brand', 'link-underline' => $underline]) }}>
    {{ $slot }}
</a>
