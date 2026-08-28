<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Facades\Config;

/**
 * Centralized branding service.
 *
 * The single source of truth for branding is config/branding.php.
 * This service exposes it to views, components and panels.
 */
final class BrandingService
{
    /**
     * Get a specific branding configuration value.
     */
    public function get(string $key, mixed $default = null): mixed
    {
        return config("branding.{$key}", $default);
    }

    /**
     * Get the brand name (translated).
     */
    public function name(): string
    {
        return (string) __(Config::string('branding.name', 'brand.name'));
    }

    /**
     * Get all brand colors.
     *
     * @return array<string, string>
     */
    public function colors(): array
    {
        $colors = [];

        foreach (Config::array('branding.colors') as $name => $color) {
            if (is_string($name) && is_string($color)) {
                $colors[$name] = $color;
            }
        }

        return $colors;
    }

    /**
     * Get a specific brand color.
     */
    public function color(string $name): string
    {
        return Config::string("branding.colors.{$name}", '#000000');
    }

    /**
     * Get Google Fonts URL for configured fonts.
     */
    public function googleFontsUrl(): ?string
    {
        $fonts = [];

        foreach (['heading', 'body'] as $type) {
            $family = Config::string("branding.typography.{$type}.family", '');

            if ($family === '' || ! Config::boolean("branding.typography.{$type}.google_font", false)) {
                continue;
            }

            $weights = [];

            foreach (Config::array("branding.typography.{$type}.weights", [400]) as $weight) {
                if (is_int($weight) || is_string($weight)) {
                    $weights[] = (string) $weight;
                }
            }

            $fonts[] = str_replace(' ', '+', $family) . ':wght@' . implode(',', $weights);
        }

        if ($fonts === []) {
            return null;
        }

        return 'https://fonts.googleapis.com/css2?family=' . implode('&family=', $fonts) . '&display=swap';
    }

    /**
     * Get brand asset configuration.
     *
     * @return array<array-key, mixed>|string|null
     */
    public function asset(string $name): array|string|null
    {
        $asset = $this->get("assets.{$name}");

        return is_array($asset) || is_string($asset) ? $asset : null;
    }

    /**
     * Get the URL for a brand asset.
     */
    public function assetUrl(string $name): ?string
    {
        $asset = $this->asset($name);
        $path = is_array($asset) ? $asset['path'] ?? null : $asset;

        if (! is_string($path) || $path === '') {
            return null;
        }

        if (str_starts_with($path, 'http')) {
            return $path;
        }

        return upload_url(mb_ltrim($path, '/'));
    }
}
