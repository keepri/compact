<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Roles\Schemas;

use App\Enums\SupportedLocale;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class RoleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Translations')
                    ->tabs(array_map(
                        static fn(SupportedLocale $locale): Tab => Tab::make(__('admin.locales.' . $locale->value))
                            ->schema([
                                TextInput::make("name.{$locale->value}")
                                    ->label(__('admin.fields.name'))
                                    ->required()
                                    ->maxLength(255),
                            ]),
                        SupportedLocale::cases(),
                    )),
                TextInput::make('slug')
                    ->label(__('admin.fields.slug'))
                    ->disabledOn('edit')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true)
                    ->regex('/^[a-z0-9\-_]+$/')
                    ->validationMessages([
                        'regex' => __('admin.validations.slug_format'),
                    ]),
            ]);
    }
}
