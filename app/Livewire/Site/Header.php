<?php

declare(strict_types=1);

namespace App\Livewire\Site;

use Illuminate\Contracts\View\View;
use Livewire\Component;

class Header extends Component
{
    /**
     * Whether the mobile navigation drawer is open. Desktop navigation ignores
     * this entirely - the drawer only exists below the `md` breakpoint.
     */
    public bool $open = false;

    public function toggle(): void
    {
        $this->open = ! $this->open;
    }

    public function render(): View
    {
        return view('livewire.site.header');
    }
}
