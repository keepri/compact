<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Users\Pages;

use App\Filament\Admin\Pages\BaseEditRecord;
use App\Filament\Admin\Resources\Users\UserResource;
use Filament\Actions\DeleteAction;
use Override;

class EditUser extends BaseEditRecord
{
    protected static string $resource = UserResource::class;

    #[Override]
    protected function getHeaderActions(): array
    {
        return [
            ...parent::getHeaderActions(),
            DeleteAction::make(),
        ];
    }
}
