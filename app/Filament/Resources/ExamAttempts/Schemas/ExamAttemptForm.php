<?php

namespace App\Filament\Resources\ExamAttempts\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ExamAttemptForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('exam_instance_id')
                    ->required()
                    ->numeric(),
                DateTimePicker::make('started_at')
                    ->label('Дата початку спроби')
                    ->required(),
                DateTimePicker::make('submitted_at')
                    ->label('Дата відправки результату')
                    ->required(),
                TextInput::make('elapsed_seconds')
                    ->label('Кількість витрачених секунд')
                    ->required()
                    ->numeric(),
                TextInput::make('score')
                    ->label('Оцінка')
                    ->numeric(),
                TextInput::make('graded_by')
                    ->label('Оцінювач')
                    ->numeric(),
                TextInput::make('client_info')
                    ->label('Інформація про пристрій')
                    ->required(),
                TextInput::make('ip')
                    ->required(),
            ]);
    }
}
