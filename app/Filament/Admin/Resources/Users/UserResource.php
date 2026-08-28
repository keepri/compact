<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Users;

use App\Filament\Admin\Resources\Users\Pages\CreateUser;
use App\Filament\Admin\Resources\Users\Pages\EditUser;
use App\Filament\Admin\Resources\Users\Pages\ListUsers;
use App\Filament\Admin\Resources\Users\Schemas\UserForm;
use App\Filament\Admin\Resources\Users\Tables\UsersTable;
use App\Models\AdminUser;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Override;

class UserResource extends Resource
{
    protected static ?string $model = AdminUser::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?int $navigationSort = 10;

    public static function getNavigationGroup(): string
    {
        return __('admin.navigation_groups.system');
    }

    public static function getNavigationLabel(): string
    {
        return __('admin.navigation.admin_users');
    }

    public static function getModelLabel(): string
    {
        return __('admin.models.admin_user');
    }

    public static function getPluralModelLabel(): string
    {
        return __('admin.models.admin_users');
    }

    #[Override]
    public static function form(Schema $schema): Schema
    {
        return UserForm::configure($schema);
    }

    #[Override]
    public static function table(Table $table): Table
    {
        return UsersTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListUsers::route('/'),
            'create' => CreateUser::route('/create'),
            'edit' => EditUser::route('/{record}/edit'),
        ];
    }
}
