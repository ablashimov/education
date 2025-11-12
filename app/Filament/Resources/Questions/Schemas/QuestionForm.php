<?php

namespace App\Filament\Resources\Questions\Schemas;

use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class QuestionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Textarea::make('text')
                    ->label('Текст')
                    ->required()
                    ->columnSpanFull(),
                Select::make('question_type_id')
                    ->label('Тип питання')
                    ->relationship('type', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                KeyValue::make('metadata')
                    ->label('Метадані')
                    ->nullable(),
            ]);
    }
}
