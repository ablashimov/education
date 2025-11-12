<?php

namespace App\Filament\Resources\Questions\RelationManagers;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ChoicesRelationManager extends RelationManager
{
    protected static string $relationship = 'choices';

    protected static ?string $title = 'Варіанти відповідей';
    protected static ?string $modelLabel = 'Варіант відповіді';

    protected static ?string $pluralModelLabel = 'Варіанти відповідей';

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            Forms\Components\Textarea::make('text')->label('Текст')->rows(3)->required(),
            Forms\Components\Toggle::make('correct')->label('Правильний'),
            Forms\Components\TextInput::make('scoring')->label('Бали')->numeric()->required(),
        ])->columns(2);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('id')->label('ID')->sortable(),
                TextColumn::make('text')->label('Текст')->limit(60)->wrap()->searchable(),
                IconColumn::make('correct')->label('Правильний')->boolean(),
                TextColumn::make('scoring')->label('Бали')->sortable(),
            ])
            ->headerActions([
                CreateAction::make()->label('Додати варіант'),
            ])
            ->recordActions([
                EditAction::make()->label('Редагувати'),
                DeleteAction::make()->label('Видалити'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()->label('Видалити'),
                ]),
            ]);
    }
}
