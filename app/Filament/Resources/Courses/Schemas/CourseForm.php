<?php

namespace App\Filament\Resources\Courses\Schemas;

use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class CourseForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->label('Назва')
                    ->maxValue(255)
                    ->required(),
                TextInput::make('slug')
                    ->label('Слаг')
                    ->maxValue(255)
                    ->required(),
                Toggle::make('is_available')
                    ->label('Доступний'),
                KeyValue::make('settings')
                    ->label('Налаштування')
                    ->nullable(),
            ]);
    }
}
