<?php

declare(strict_types=1);

namespace App\Filament\Admin\Pages;

use Filament\Actions\Action;
use Filament\Resources\Pages\EditRecord;
use Override;

abstract class BaseEditRecord extends EditRecord
{
    #[Override]
    protected function getRedirectUrl(): ?string
    {
        return $this->getResource()::getUrl('index');
    }

    #[Override]
    protected function getHeaderActions(): array
    {
        return [
            Action::make('save')
                ->label(__('admin.actions.save'))
                ->icon('heroicon-m-check')
                ->color('primary')
                ->action(function (): void {
                    $this->save(shouldRedirect: false);
                }),
        ];
    }
}
