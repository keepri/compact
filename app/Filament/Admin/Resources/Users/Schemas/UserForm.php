<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Users\Schemas;

use App\Models\Role;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label(__('admin.fields.name'))
                    ->required(),
                TextInput::make('email')
                    ->label(__('admin.fields.email'))
                    ->email()
                    ->required()
                    ->disabled(fn($context): bool => $context === 'edit'),
                DateTimePicker::make('email_verified_at')
                    ->label(__('admin.fields.email_verified_at'))
                    ->disabled()
                    ->native(false)
                    ->format('Y-m-d H:i')
                    ->hidden(fn($context): bool => $context === 'create'),
                Select::make('role_id')
                    ->label(__('admin.fields.role'))
                    ->relationship('role', 'slug')
                    ->getOptionLabelFromRecordUsing(fn(Role $record): string => $record->getLocalizedName())
                    ->searchable()
                    ->preload(),
                TextInput::make('password')
                    ->label(__('admin.fields.password'))
                    ->password()
                    ->required(fn($context): bool => $context === 'create')
                    ->dehydrated(fn($state): bool => filled($state))
                    ->dehydrateStateUsing(fn($state): string => bcrypt($state)),
            ]);
    }
}
