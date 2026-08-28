<?php

declare(strict_types=1);

namespace App\Livewire\Pages;

use Livewire\Attributes\Layout;
use Livewire\Component;

/**
 * Shared plumbing for the public marketing pages. Each page differs only by its
 * translation namespace, so the document title and the social meta tags are
 * derived once here; the subclass only names its own view.
 */
#[Layout('components.layouts.app')]
abstract class SitePage extends Component
{
    /**
     * The lang file backing this page, e.g. 'concert' reads lang/{locale}/concert.php.
     */
    abstract protected function langKey(): string;

    protected function title(): string
    {
        return __($this->langKey() . '.meta.title');
    }

    /**
     * Meta tags handed to the layout, which forwards them to x-partials.head.
     *
     * @return array<string, string>
     */
    protected function layoutData(): array
    {
        $key = $this->langKey();

        return [
            'description' => __("{$key}.meta.description"),
            'ogTitle' => __("{$key}.meta.og_title"),
            'ogDescription' => __("{$key}.meta.og_description"),
        ];
    }
}
