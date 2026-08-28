<?php

declare(strict_types=1);

namespace App\Livewire\Pages;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Config;

class Concert extends SitePage
{
    public function render(): View
    {
        return view('livewire.pages.concert')
            ->title($this->title())
            ->layout('components.layouts.app', $this->layoutData());
    }

    /**
     * The venue map embed, with its language parameter pointed at the active
     * locale so the map labels match the rest of the page.
     */
    public function mapEmbedUrl(): string
    {
        return str_replace(':locale', app()->getLocale(), Config::string('site.maps.embed'));
    }

    protected function langKey(): string
    {
        return 'concert';
    }
}
