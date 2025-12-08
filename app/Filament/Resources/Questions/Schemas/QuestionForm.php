<?php

namespace App\Filament\Resources\Questions\Schemas;

use App\Enums\QuestionTypeEnum;
use App\Models\QuestionType;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class QuestionForm
{
    public static function configure(Schema $schema): Schema
    {
        $sequenceType = QuestionType::where('slug', QuestionTypeEnum::VYBIR_POSLIDOVNOSTI)->first();
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
                    ->live()
                    ->preload()
                    ->required(),
                KeyValue::make('metadata')
                    ->label('Метадані')
                    ->nullable(),
                Repeater::make('choices')
                    ->relationship()
                    ->label('Варіанти відповідей')
                    ->defaultItems(0)
                    ->schema([
                        Textarea::make('text')->label('Текст')->rows(3)->required(),
                        Toggle::make('correct')->label('Правильний'),
                        TextInput::make('scoring')->label('Бали')->numeric()->required(),
                        TextInput::make('order')
                            ->label('Порядок правильних відповідей')
                            ->numeric()
                            ->hidden(fn($get, $record) => $get('../../question_type_id')  !== $sequenceType->id)
                            ->required(),
                    ])
                    ->columnSpanFull()
                    ->collapsible()
                    ->itemLabel(fn (array $state): ?string => $state['file'] ?? null),
            ]);
    }
}
