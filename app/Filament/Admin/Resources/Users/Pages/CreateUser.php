<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Users\Pages;

use App\Filament\Admin\Pages\BaseCreateRecord;
use App\Filament\Admin\Resources\Users\UserResource;

class CreateUser extends BaseCreateRecord
{
    protected static string $resource = UserResource::class;
}
