<?php

namespace App\Filament\Resources\Courses\RelationManagers;

use App\Filament\Resources\Modules\ModuleResource;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\EditAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class ModulesRelationManager extends RelationManager
{
    protected static string $relationship = 'modules';

    protected static ?string $title = 'Модулі';

    public function form(Schema $schema): Schema
    {
        return ModuleResource::form($schema)->columns(2);
    }

    public function table(Table $table): Table
    {
        return ModuleResource::table($table)
            ->headerActions([
                CreateAction::make()->label('Додати модуль'),
            ])
            ->recordActions([
                EditAction::make()->label('Редагувати'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
//                    DeleteBulkAction::make()->label('Видалити'),
                ]),
            ]);
    }
}
