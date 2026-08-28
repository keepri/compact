<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\ErrorPages\Tables;

use Filament\Support\Enums\FontWeight;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ErrorPagesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('slug')
                    ->label(__('admin.fields.slug'))
                    ->weight(FontWeight::Bold)
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'not_found' => 'warning',
                        'error' => 'danger',
                        default => 'gray',
                    })
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('heading')
                    ->label(__('admin.fields.heading'))
                    ->formatStateUsing(function ($state) {
                        if (is_array($state)) {
                            return $state[app()->getLocale()] ?? $state['en'] ?? '';
                        }

                        return $state ?? '';
                    })
                    ->searchable()
                    ->limit(50)
                    ->toggleable(),
            ])
            ->defaultSort('slug');
    }
}
