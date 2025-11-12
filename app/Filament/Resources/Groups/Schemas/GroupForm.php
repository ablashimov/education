<?php

namespace App\Filament\Resources\Groups\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class GroupForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Назва')
                    ->required(),
                Select::make('course_id')
                    ->label('Курс')
                    ->relationship('course', 'title')
                    ->required(),
                TextInput::make('description')
                    ->label('Опис'),
                DatePicker::make('start_date')
                    ->label('Початок')
                    ->required(),
                DatePicker::make('end_date')
                    ->label('Кінець')
                    ->required(),
            ]);
    }
}
