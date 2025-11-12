<?php

namespace App\Filament\Resources\Exams\Schemas;

use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ExamForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('course_id')
                    ->label('Курс')
                    ->relationship('course', 'title')
                    ->required(),
                Select::make('module_id')
                    ->label('Модуль')
                    ->relationship('module', 'title', modifyQueryUsing: function ($query, $get) {
                        $query->where('course_id', $get('course_id'));
                    }),
                TextInput::make('title')
                    ->label('Назва')
                    ->maxValue(255)
                    ->required(),
                RichEditor::make('description')
                    ->label('Опис')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('attempts_allowed')
                    ->label('К-сть спроб')
                    ->required()
                    ->numeric(),
                TextInput::make('time_limit')
                    ->label('Ліміт часу (хв)')
                    ->required()
                    ->numeric(),
                KeyValue::make('config')
                    ->label('Конфіг')
                    ->nullable(),
            ]);
    }
}
