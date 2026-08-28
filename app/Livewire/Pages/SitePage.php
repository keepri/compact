<?php

declare(strict_types=1);

namespace App\Livewire\Pages;

use Livewire\Attributes\Layout;
use Livewire\Component;

/**
 * Shared plumbing for the public marketing pages. The meta tags are derived
 * from the route name in x-partials.head, so all a page has left in common is
 * the layout it renders into.
 */
#[Layout('components.layouts.app')]
abstract class SitePage extends Component
{
}
