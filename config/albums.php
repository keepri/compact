<?php

declare(strict_types=1);

/*
 * Anniversary double album data. Album names, tracklists, guests and studio
 * details are locale-invariant and live here exactly once. Prose that changes
 * per language lives in lang/{locale}/concert.php under the 'albums' key.
 */
return [
    [
        'slug' => 'lumea-arde',
        'title' => 'Lumea arde',
        'year' => 2026,
        'tracks' => [
            ['number' => 1, 'title' => 'Nu mă-ntorc din drum cu Intro', 'duration' => '6:07'],
            ['number' => 2, 'title' => 'Aproape de nori', 'duration' => '3:25'],
            ['number' => 3, 'title' => 'Cine știe pe unde ești', 'duration' => '3:23'],
            ['number' => 4, 'title' => 'Clara', 'duration' => '3:54'],
            ['number' => 5, 'title' => 'Aproape de tine', 'duration' => '3:26'],
            ['number' => 6, 'title' => 'Îmi pare rău', 'duration' => '3:31'],
            ['number' => 7, 'title' => 'Lumea arde', 'duration' => '3:51'],
            ['number' => 8, 'title' => 'Poate nu e prea târziu', 'duration' => '3:34'],
            ['number' => 9, 'title' => '22 decembrie', 'duration' => '2:09', 'instrumental' => true],
            ['number' => 10, 'title' => 'Scrisoare', 'duration' => '4:35'],
            ['number' => 11, 'title' => 'Timpul rezolvă totul', 'duration' => '3:45'],
            ['number' => 12, 'title' => 'Nu pot să te pierd', 'duration' => '3:28'],
            ['number' => 13, 'title' => 'Ploaia care cade', 'duration' => '3:59'],
            ['number' => 14, 'title' => 'Străzile pustii', 'duration' => '4:05'],
        ],
        'composer' => 'Adrian Ordean',
        'guests' => [
            'Gabriel (Guriță) Nicolau — vocal (piesa 12)',
            'Codruț Croitoru — vocal (piesa 13)',
            'Leo Iorga — vocal (piesa 14)',
            'Monel Puia — Key (piesele 3, 8)',
            'Denise Ordean — Backing vocals',
            'Corul de copii "Academia de Rock" Costi Cămărășan (piesa 4)',
        ],
    ],
    [
        'slug' => 'vesnic-calator',
        'title' => 'Veșnic călător',
        'year' => 2026,
        'tracks' => [
            ['number' => 15, 'title' => 'Veșnic călător', 'duration' => '3:42'],
            ['number' => 16, 'title' => 'Înger Alb', 'duration' => '4:18'],
            ['number' => 17, 'title' => 'Fals decor', 'duration' => '5:25'],
            ['number' => 18, 'title' => 'Spre tine alerg', 'duration' => '4:15'],
            ['number' => 19, 'title' => 'Fetele din România', 'duration' => '2:48'],
            ['number' => 20, 'title' => 'Ne vrem dragostea înapoi', 'duration' => '3:52'],
            ['number' => 21, 'title' => 'Ard ruguri', 'duration' => '4:28'],
            ['number' => 22, 'title' => 'Inima mea la tine a rămas', 'duration' => '3:01'],
            ['number' => 23, 'title' => 'Zorii s-au trezit de ziua ta', 'duration' => '2:40'],
            ['number' => 24, 'title' => 'Transilvania', 'duration' => '5:30'],
            ['number' => 25, 'title' => 'Puii au noroc', 'duration' => '3:34'],
            ['number' => 26, 'title' => 'Tu ești focul meu târziu', 'duration' => '5:21'],
            ['number' => 27, 'title' => 'Raze Gamma', 'duration' => '3:05'],
            ['number' => 28, 'title' => 'Toți suntem Compact', 'duration' => '2:56'],
        ],
        'composer' => 'Costi Cămărășan',
        'guests' => [
            'Aurel Tămaș — vocal (piesa 24)',
            'Gabriel (Guriță) Nicolau — vocal (piesele 19, 20, 22)',
            'Leo Iorga — vocal (piesa 24)',
            'Monel Puia — key (piesele 16, 20, 21)',
            'Marius Roje — key (piesa 17)',
            'Denise Ordean — backing vocals',
            'Darius Herghiligiu — aranjamente muzicale (piesa 16)',
        ],
    ],
];
