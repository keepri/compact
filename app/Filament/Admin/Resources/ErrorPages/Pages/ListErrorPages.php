<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\ErrorPages\Pages;

use App\Filament\Admin\Resources\ErrorPages\ErrorPageResource;
use Filament\Resources\Pages\ListRecords;
use Override;

class ListErrorPages extends ListRecords
{
    #[Override]
    protected static string $resource = ErrorPageResource::class;
}
