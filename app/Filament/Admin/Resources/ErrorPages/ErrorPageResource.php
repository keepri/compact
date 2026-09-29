<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\ErrorPages;

use App\Filament\Admin\Resources\ErrorPages\Pages\EditErrorPage;
use App\Filament\Admin\Resources\ErrorPages\Pages\ListErrorPages;
use App\Filament\Admin\Resources\ErrorPages\Schemas\ErrorPageForm;
use App\Filament\Admin\Resources\ErrorPages\Tables\ErrorPagesTable;
use App\Models\ErrorPage;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Override;

class ErrorPageResource extends Resource
{
    protected static ?string $model = ErrorPage::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedExclamationTriangle;

    protected static ?int $navigationSort = 100;

    public static function getNavigationLabel(): string
    {
        return __('admin.navigation.error_pages');
    }

    #[Override]
    public static function form(Schema $schema): Schema
    {
        return ErrorPageForm::configure($schema);
    }

    #[Override]
    public static function table(Table $table): Table
    {
        return ErrorPagesTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListErrorPages::route('/'),
            'edit' => EditErrorPage::route('/{record}/edit'),
        ];
    }
}
