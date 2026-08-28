<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\ErrorPages\Schemas;

use App\Enums\SupportedLocale;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class ErrorPageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Translations')
                    ->persistTabInQueryString()
                    ->tabs(array_map(
                        static fn(SupportedLocale $locale): Tab => Tab::make(__('admin.locales.' . $locale->value))
                            ->schema([
                                TextInput::make("heading.{$locale->value}")
                                    ->label(__("admin.fields.heading_{$locale->value}"))
                                    ->required()
                                    ->maxLength(255),
                                RichEditor::make("message.{$locale->value}")
                                    ->label(__("admin.fields.message_{$locale->value}"))
                                    ->toolbarButtons([
                                        'bold',
                                        'italic',
                                        'link',
                                        'redo',
                                        'underline',
                                        'undo',
                                    ])
                                    ->required(),
                            ]),
                        SupportedLocale::cases(),
                    ))
                    ->columnSpanFull(),
            ]);
    }
}
