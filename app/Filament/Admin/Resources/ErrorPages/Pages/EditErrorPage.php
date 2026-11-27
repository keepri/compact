<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\ErrorPages\Pages;

use App\Filament\Admin\Resources\ErrorPages\ErrorPageResource;
use Filament\Resources\Pages\EditRecord;
use Override;

class EditErrorPage extends EditRecord
{
    #[Override]
    protected static string $resource = ErrorPageResource::class;

    #[Override]
    protected function getRedirectUrl(): ?string
    {
        return $this->getResource()::getUrl('index');
    }
}
