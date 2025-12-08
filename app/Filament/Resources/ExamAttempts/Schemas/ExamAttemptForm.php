<?php

namespace App\Filament\Resources\ExamAttempts\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Placeholder;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ExamAttemptForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Info')
                    ->schema([
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
                            ->disabled()
                            ->default(auth()->user()->id)
                            ->numeric(),
                        TextInput::make('client_info')
                            ->label('Інформація про пристрій')
                            ->required(),
                        TextInput::make('ip')
                            ->required(),
                    ])->columns(2),
                Section::make('Відповіді')
                    ->schema([
                        Repeater::make('answers')
                            ->label('Відповіді')
                            ->relationship()
                            ->schema([
                                TextEntry::make('question.text')
                                    ->label('Запитання'),
                                TextInput::make('answer')
                                    ->label('Відповідь')
                                    ->disabled(),
                                Toggle::make('is_correct')
                                    ->label('Чи правильна відповідь'),
                            ])
                            ->addable(false)
                            ->deletable(false)
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
