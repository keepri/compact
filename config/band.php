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
        ['slug' => 'adrian-marias', 'name' => 'Adrian (GeaGea) Mariaș'],
        ['slug' => 'robert-risteiu', 'name' => 'Robert (Roby) Risteiu'],
        ['slug' => 'marius-macavei', 'name' => 'Marius Macavei'],
        ['slug' => 'willy-gorgan', 'name' => 'Willy Gorgan'],
    ],

    'eras' => [
        [
            'slug' => '1976-1979',
            'years' => '1976 – 1979',
            'photo' => 'timeline/1976-1979.webp',
            'lineup' => ['Costi Cămărășan', 'Marius Luca', 'Cornel Moldovan', 'Teo Peter', 'Balázs László'],
            'founders' => ['Costi Cămărășan', 'Teo Peter', 'Marius Luca', 'Cornel Moldovan'],
            'awards' => [
                ['year' => 1978, 'name' => 'Premiul II la Festivalul Primăvara Studențească, ediția XIII'],
            ],
        ],
        [
            'slug' => '1980-1981',
            'years' => '1980 – 1981',
            'photo' => 'timeline/1980-1981.webp',
            'lineup' => ['Costi Cămărășan', 'Teo Peter', 'Radu Marpozan', 'Papp Géza', 'Marian Corjan', 'Paul Ciuci', 'Venczel Peter'],
            'awards' => [
                ['year' => 1980, 'name' => 'Marele Premiu la Festivalul Perpetuum Vox Transilvanie'],
                ['year' => 1981, 'name' => 'Premiul I la Festivalul de Rock, Jazz, Folk de la Craiova'],
            ],
        ],
        [
            'slug' => '1982-1987',
            'years' => '1982 – 1987',
            'photo' => 'timeline/1982-1987.webp',
            'lineup' => ['Costi Cămărășan', 'Teo Peter', 'Paul Ciuci', 'Aurel Vasilescu', 'Mircea Kiraly', 'Vlady Cnejevici'],
            'discography' => [
                ['year' => 1982, 'title' => 'Format Rock 6', 'format' => 'LP'],
                ['year' => 1984, 'title' => 'Fata din Vis', 'format' => 'LP'],
            ],
            'hit_songs' => [
                'Spațiu',
                'Inima rece',
                'Păsări cu ochi de foc',
                'Ca doi străini',
                'Fata din Vis',
            ],
            'awards' => [
                ['year' => 1982, 'name' => 'Marele Premiu pentru interpretare de la Costinești'],
                ['year' => 1982, 'name' => 'Premiul de Popularitate Costinești'],
                ['year' => 1985, 'name' => 'Marele Premiu la Sărbătorile Mării — Costinești'],
            ],
            'international' => [
                ['year' => 1985, 'event' => 'Festivalul Șlagărelor de la Dresda'],
                ['year' => 1986, 'event' => 'Turneu în URSS, 15 concerte, timp de o lună, numai în capitale de republici'],
                ['year' => 1987, 'event' => 'Turneu în Bulgaria'],
            ],
        ],
        [
            'slug' => '1988-1989',
            'years' => '1988 – 1989',
            'photo' => 'timeline/1988-1989.webp',
            'lineup' => ['Costi Cămărășan', 'Rareș Totu', 'Jozsef Lenard', 'Alexandru Varga'],
            'discography' => [
                ['year' => 1988, 'title' => 'Cântec pentru prieteni', 'format' => 'LP'],
            ],
            'hit_songs' => [
                'Cântec pentru prieteni',
                'Nostalgie',
                'Cine ești tu oare',
                'Te visez mereu',
            ],
            'international' => [
                ['year' => 1988, 'event' => 'Turneu în Republica Moldova'],
                ['year' => 1989, 'event' => 'Festivalul Cântecului de la Berlin'],
            ],
        ],
        [
            'slug' => '1990-1992',
            'years' => '1990 – 1992',
            'photo' => 'timeline/1990-1992.webp',
            'lineup' => ['Costi Cămărășan', 'Jozsef Lenard', 'Alexandru Varga', 'Călin Efendi Ciama', 'Mircea Rusu'],
            'discography' => [
                ['year' => 1991, 'title' => 'Cine ești tu oare', 'format' => 'CD'],
                ['year' => 1992, 'title' => 'Vin vremuri noi', 'format' => 'LP'],
            ],
            'hit_songs' => [
                'Să te gândești la mine',
                'Nu uita',
            ],
            'international' => [
                ['year' => 1990, 'event' => 'Festivalul British Rock for Romania, cu Crazyhead, Jesus Jones, Skin Games'],
                ['year' => 1990, 'event' => 'Turneu în Republica Moldova'],
                ['year' => 1991, 'event' => 'Recital de gală la Festivalul Mamaia'],
                ['year' => 1992, 'event' => 'Recital la Festivalul Rock 92, alături de Uriah Heep și Ian Gillan'],
                ['year' => 1992, 'event' => 'Turneu în Republica Moldova'],
            ],
        ],
        [
            'slug' => '1993-1996',
            'years' => '1993 – 1996',
            'photo' => 'timeline/1993-1996.webp',
            'lineup' => ['Costi Cămărășan', 'Mircea Rusu', 'Ghiță Gabriel', 'Ciprian Mateian', 'Robert Cozma', 'Robert Banto'],
            'discography' => [
                ['year' => 1994, 'title' => 'Mă voi întoarce', 'format' => 'CD'],
                ['year' => 1995, 'title' => 'Transilvania', 'format' => 'CD / CC'],
                ['year' => 1996, 'title' => 'Compact 88-95', 'format' => 'CD (dublu disc de platină)'],
            ],
            'hit_songs' => [
                'Mă voi întoarce',
                'Transilvania',
                'Norul Fragil',
                'Fericiți-nefericiți',
                'Trenul pierdut',
                'Singur în noapte',
                'Toamna în sufletul meu',
            ],
            'international' => [
                ['year' => 1993, 'event' => 'Recital la Brașov și Sofia, alături de Nazareth'],
                ['year' => 1994, 'event' => 'Turneu Marlboro Music împreună cu Holograf și Iris'],
            ],
        ],
        [
            'slug' => '1997-2006',
            'years' => '1997 – 2006',
            'lineup' => ['Costi Cămărășan', 'Covaci László', 'Paul Baciu', 'Alex Malschi', 'Ionel Ladaru', 'Sergiu Berindei'],
            'discography' => [
                ['year' => 1999, 'title' => 'De la Compact la un alt început', 'format' => 'CD / CC'],
            ],
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
            'photo' => 'timeline/2026.webp',
            'lineup' => ['Costi Cămărășan', 'Adrian Ordean', 'Adrian (GeaGea) Mariaș', 'Robert (Roby) Risteiu', 'Marius Macavei', 'Willy Gorgan'],
            'stats' => [
                'concerts' => 6000,
                'spectators_since_2023' => 350000,
            ],
            'discography' => [
                ['year' => 2026, 'title' => 'Lumea arde / Veșnic călător', 'format' => 'Dublu album / USB, streaming'],
            ],
            'international' => [
                ['year' => 2018, 'event' => 'Recital alături de Scorpions'],
                ['year' => 2021, 'event' => 'Recital alături de Dire Straits Experience'],
                ['year' => 2022, 'event' => 'La Zilele Clujului, Compact primește distincția „Compact 45" acordată de primarul Municipiului Cluj, d-l Emil Boc, în fața a 50000 de oameni, ca semn de apreciere a activității excepționale a grupului'],
            ],
        ],
    ],
];
