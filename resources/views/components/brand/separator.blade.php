@props(['centered' => false])

@if ($centered)
    <div {{ $attributes->class(['flex w-full justify-center']) }}>
        <div class="bg-brand-primary h-px w-16"></div>
    </div>
@else
    <div {{ $attributes->class(['h-px w-16 bg-brand-primary']) }}></div>
@endif
