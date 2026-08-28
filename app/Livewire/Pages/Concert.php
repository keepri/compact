<?php

declare(strict_types=1);

namespace App\Livewire\Pages;

use Illuminate\Contracts\View\View;

class Concert extends SitePage
{
    public function render(): View
    {
        return view('livewire.pages.concert')
            ->title($this->title())
            ->layout('components.layouts.app', $this->layoutData());
    }

    protected function langKey(): string
    {
        return 'concert';
    }
}
