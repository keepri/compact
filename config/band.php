<?php

declare(strict_types=1);

/*
 * Locale-invariant band data. Member names, era years and the per-era line-ups
 * are the same in every language, so they live here exactly once; the roles,
 * titles and prose that do change live in lang/{locale}/band.php, keyed by the
 * same slugs.
 */
return [
    'lineup' => [
        ['slug' => 'costi-camarasan', 'name' => 'Costi Cămărășan'],
        ['slug' => 'adrian-ordean', 'name' => 'Adrian Ordean'],
        ['slug' => 'adrian-marias', 'name' => 'Adrian Mariaș'],
        ['slug' => 'robert-risteiu', 'name' => 'Robert Risteiu'],
        ['slug' => 'marius-macavei', 'name' => 'Marius Macavei'],
        ['slug' => 'wily-gorgan', 'name' => 'Wily Gorgan'],
    ],

    'eras' => [
        [
            'slug' => '1976-1979',
            'years' => '1976 – 1979',
            'lineup' => ['Costi Cămărășan', 'Marius Luca', 'Cornel Moldovan', 'Teo Peter', 'Balázs László'],
        ],
        [
            'slug' => '1980-1981',
            'years' => '1980 – 1981',
            'lineup' => ['Costi Cămărășan', 'Teo Peter', 'Radu Marpozan', 'Papp Géza', 'Marian Corjan', 'Paul Ciuci', 'Venczel Peter'],
        ],
        [
            'slug' => '1982-1987',
            'years' => '1982 – 1987',
            'lineup' => ['Costi Cămărășan', 'Teo Peter', 'Paul Ciuci', 'Aurel Vasilescu', 'Mircea Kiraly', 'Vlady Cnejevici'],
        ],
        [
            'slug' => '1988-1989',
            'years' => '1988 – 1989',
            'lineup' => ['Costi Cămărășan', 'Rareș Totu', 'Jozsef Lenard', 'Alexandru Varga'],
        ],
        [
            'slug' => '1990-1992',
            'years' => '1990 – 1992',
            'lineup' => ['Costi Cămărășan', 'Jozsef Lenard', 'Alexandru Varga', 'Călin Efendi Ciama', 'Mircea Rusu'],
        ],
        [
            'slug' => '1993-1996',
            'years' => '1993 – 1996',
            'lineup' => ['Costi Cămărășan', 'Mircea Rusu', 'Ghiță Gabriel', 'Ciprian Mateian', 'Robert Cozma', 'Robert Banto'],
        ],
        [
            'slug' => '1997-2006',
            'years' => '1997 – 2006',
            'lineup' => ['Costi Cămărășan', 'Covaci László', 'Paul Baciu', 'Alex Malschi', 'Ionel Ladaru', 'Sergiu Berindei'],
        ],
        [
            'slug' => '2012-2016',
            'years' => '2012 – 2016',
            'lineup' => ['Costi Cămărășan', 'Richie Bordea', 'Călin Cămărășan', 'Dudu Isabel', 'Liviu Sorescu', 'Dan Vaida'],
        ],
        [
            'slug' => '2017',
            'years' => '2017',
            'lineup' => ['Costi Cămărășan', 'Adrian Ordean', 'Aurel Vasilescu', 'Leo Iorga', 'Monel Puia', 'Adrian Tinca'],
        ],
        [
            'slug' => '2026',
            'years' => '2026',
            'lineup' => ['Costi Cămărășan', 'Adrian Ordean', 'Adrian Mariaș', 'Robert Risteiu', 'Marius Macavei', 'Wily Gorgan'],
        ],
    ],
];
