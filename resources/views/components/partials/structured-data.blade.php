@php
    // Assembled entirely inside this block: Blade compiles directives in an
    // echo expression, and `@context` there would be read as one.
    // The band itself, on every page. json_encode with no pretty-printing keeps
    // this to one line in the markup; Google reads it either way.
    $graph = [
        [
            '@type' => 'MusicGroup',
            '@id' => url('/') . '#band',
            'name' => __('brand.name'),
            'url' => url('/'),
            'image' => asset('images/compact-band-diagonal.webp'),
            'description' => __('site.meta.description'),
            'genre' => 'Rock',
            'foundingDate' => '1976',
            'foundingLocation' => [
                '@type' => 'Place',
                'name' => 'Cluj-Napoca, Romania',
            ],
            'member' => array_map(
                fn(array $member): array => [
                    '@type' => 'Person',
                    'name' => $member['name'],
                ],
                config('band.lineup'),
            ),
        ],
    ];

    // The anniversary concert, only on the page that is about it.
    if (request()->routeIs('concert')) {
        $concert = config('site.concert');

        $graph[] = [
            '@type' => 'MusicEvent',
            'name' => __('concert.header.title'),
            'description' => __('concert.meta.description'),
            'url' => route('concert'),
            'image' => asset('images/compact-band-diagonal.webp'),
            'startDate' => $concert['starts_at'],
            'eventStatus' => 'https://schema.org/EventScheduled',
            'eventAttendanceMode' =>
                'https://schema.org/OfflineEventAttendanceMode',
            'performer' => ['@id' => url('/') . '#band'],
            'location' => [
                '@type' => 'Place',
                'name' => $concert['venue']['name'],
                'address' => [
                    '@type' => 'PostalAddress',
                    'streetAddress' => $concert['venue']['street'],
                    'postalCode' => $concert['venue']['postal_code'],
                    'addressLocality' => $concert['venue']['city'],
                    'addressCountry' => $concert['venue']['country'],
                ],
            ],
            'offers' => [
                '@type' => 'Offer',
                'url' => config('site.tickets.url'),
                'availability' => 'https://schema.org/InStock',
            ],
        ];
    }

    $jsonLd = json_encode(
        ['@context' => 'https://schema.org', '@graph' => $graph],
        JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE,
    );
@endphp

<script type="application/ld+json">
    {!! $jsonLd !!}
</script>
