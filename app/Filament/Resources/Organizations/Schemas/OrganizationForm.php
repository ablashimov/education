<?php

namespace App\Filament\Resources\Organizations\Schemas;

use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class OrganizationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Назва')
                    ->required(),
                TextInput::make('slug')
                    ->label('Слаг')
                    ->unique('organizations', 'slug'),
                KeyValue::make('settings')
                    ->label('Налаштування')
                    ->nullable(),
                Select::make('status_id')
                    ->label('Статус')
                    ->relationship('status', 'name')
                    ->required()
                    ->preload()
                    ->searchable(),
            ]);
    }
}
