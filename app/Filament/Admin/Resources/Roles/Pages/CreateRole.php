<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Roles\Pages;

use App\Filament\Admin\Pages\BaseCreateRecord;
use App\Filament\Admin\Resources\Roles\RoleResource;

class CreateRole extends BaseCreateRecord
{
    protected static string $resource = RoleResource::class;
}
