@php
    /** @var \App\Services\BrandingService $branding */
    $branding = app(\App\Services\BrandingService::class);
    $headingFamily = $branding->get('typography.heading.family');
    $bodyFamily = $branding->get('typography.body.family');
@endphp
<style>
    :root {
        @foreach ($branding->colors() as $name => $hex)
            --brand-{{ str_replace('_', '-', $name) }}: {{ $hex }};
        @endforeach
        @if ($headingFamily)
            --brand-font-heading: '{{ $headingFamily }}';
        @endif
        @if ($bodyFamily)
            --brand-font-body: '{{ $bodyFamily }}';
        @endif
    }
</style>
