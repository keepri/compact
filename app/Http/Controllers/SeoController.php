<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Response;

/**
 * robots.txt and sitemap.xml are served by Laravel rather than sitting in
 * public/ so the absolute URLs they carry follow APP_URL in every environment.
 */
class SeoController extends Controller
{
    public function robots(): Response
    {
        $lines = [
            'User-agent: *',
            'Allow: /',
            'Disallow: /admin',
            // Following the switch would flip the crawler's session locale and
            // serve English copy at the Romanian URLs. Only `ro` is indexed.
            'Disallow: /lang/',
            '',
            'Sitemap: ' . route('sitemap'),
            '',
        ];

        return response(implode("\n", $lines), 200, ['Content-Type' => 'text/plain']);
    }

    public function sitemap(): Response
    {
        /** @var list<array{key: string, route: string, cta: bool}> $nav */
        $nav = config('site.nav');

        // Built as a string rather than a Blade view: blade-formatter rewrites
        // the `<?xml` declaration a template would need and breaks the output.
        $urls = array_map(
            fn(string $name): string => '    <url><loc>' . route($name) . '</loc></url>',
            ['home', ...array_column($nav, 'route')],
        );

        $xml = implode("\n", [
            '<?xml version="1.0" encoding="UTF-8"?>',
            '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">',
            ...$urls,
            '</urlset>',
            '',
        ]);

        return response($xml, 200, ['Content-Type' => 'application/xml']);
    }
}
