<?php

declare(strict_types=1);

namespace App\Livewire\Pages;

use Illuminate\Contracts\View\View;

class Contact extends SitePage
{
    public function render(): View
    {
        return view('livewire.pages.contact');
    }
}
