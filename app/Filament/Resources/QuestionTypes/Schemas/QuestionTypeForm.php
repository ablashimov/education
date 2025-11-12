<?php

namespace App\Filament\Resources\QuestionTypes\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class QuestionTypeForm
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
                    ->required(),
            ]);
    }
}
