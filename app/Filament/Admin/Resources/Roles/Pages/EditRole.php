<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Roles\Pages;

use App\Filament\Admin\Pages\BaseEditRecord;
use App\Filament\Admin\Resources\Roles\RoleResource;
use App\Models\Role;
use Filament\Actions\DeleteAction;
use Override;

class EditRole extends BaseEditRecord
{
    protected static string $resource = RoleResource::class;

    #[Override]
    protected function mutateFormDataBeforeFill(array $data): array
    {
        $record = $this->getRecord();

        if ($record instanceof Role) {
            $data['name'] = $record->getTranslations('name');
        }

        return $data;
    }

    #[Override]
    protected function getHeaderActions(): array
    {
        return [
            ...parent::getHeaderActions(),
            DeleteAction::make(),
        ];
    }
}
