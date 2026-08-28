<?php

declare(strict_types=1);

return [
    /*
     * Primary navigation. One list drives the desktop nav, the mobile drawer and
     * the footer - the labels come from lang/{locale}/site.php via the item key,
     * where `nav.<key>` is the short form and `nav.<key>_full` the long one.
     */
    'nav' => [
        ['key' => 'concert', 'route' => 'concert', 'cta' => true],
        ['key' => 'band', 'route' => 'band', 'cta' => false],
        ['key' => 'contact', 'route' => 'contact', 'cta' => false],
    ],

    /*
     * Addresses shown on /contact and in the footer. Labels are translated;
     * the addresses themselves live here so they are written once.
     */
    'contact' => [
        'booking' => 'booking@compact.ro',
        'press' => 'presa@compact.ro',
        'management' => 'management@compact.ro',
    ],

    /*
     * The venue map on /concert. The embed URL carries a `!1s<lang>!2s<region>`
     * pair at the end - App\Livewire\Pages\Concert swaps the language for the
     * active locale so the map labels follow the site.
     */
    'maps' => [
        'link' => 'https://maps.google.com/?q=Cinema+Florin+Piersic+Cluj+Napoca',
        'embed' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2732.504208392653!2d23.58770777660253!3d46.774668271125684!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47490e9eec9fbce1%3A0x94e47de55d1ee522!2s%22Florin%20Piersic%22%20Cinema!5e0!3m2!1s:locale!2sro!4v1787818671031!5m2!1s:locale!2sro',
    ],
];
