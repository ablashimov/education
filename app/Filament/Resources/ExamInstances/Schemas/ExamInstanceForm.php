<?php

namespace App\Filament\Resources\ExamInstances\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ExamInstanceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
//                Select::make('assignment_id')
//                    ->relationship('assignment', 'id')
//                    ->required(),
                Select::make('user_id')
                    ->label('Користувач')
                    ->disabled()
                    ->relationship('user', 'name')
                    ->required(),
                TextInput::make('attempt_number')
                    ->label('Спроба')
                    ->disabled()
                    ->required()
                    ->numeric(),
                DateTimePicker::make('start_at')
                    ->label('Дата початку')
                    ->required(),
                DateTimePicker::make('end_at')
                    ->label('Дата закінчення')
                    ->required(),
            ]);
    }
}
