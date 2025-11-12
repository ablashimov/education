<?php

namespace App\Filament\Resources\Modules\Schemas;

use App\Filament\Resources\Courses\RelationManagers\ModulesRelationManager;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ModuleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('course_id')
                    ->label('Курс')
                    ->relationship('course', 'title')
                    ->hiddenOn(ModulesRelationManager::class)
                    ->required(),
                TextInput::make('title')
                    ->maxValue(255)
                    ->label('Назва')
                    ->required(),
                TextInput::make('order')
                    ->label('Порядок')
                    ->required()
                    ->numeric(),
                KeyValue::make('settings')
                    ->label('Налаштування')
                    ->nullable(),
            ]);
    }
}
