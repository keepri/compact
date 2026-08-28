<?php

declare(strict_types=1);

namespace App\Filament\Admin\Pages;

use Filament\Resources\Pages\CreateRecord;
use Override;

abstract class BaseCreateRecord extends CreateRecord
{
    #[Override]
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
