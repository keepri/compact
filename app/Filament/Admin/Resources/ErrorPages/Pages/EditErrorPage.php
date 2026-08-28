<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\ErrorPages\Pages;

use App\Filament\Admin\Pages\BaseEditRecord;
use App\Filament\Admin\Resources\ErrorPages\ErrorPageResource;

class EditErrorPage extends BaseEditRecord
{
    protected static string $resource = ErrorPageResource::class;
}
