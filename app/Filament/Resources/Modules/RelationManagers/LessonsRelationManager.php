<?php

namespace App\Filament\Resources\Modules\RelationManagers;

use App\Filament\Resources\Lessons\LessonResource;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\EditAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class LessonsRelationManager extends RelationManager
{
    protected static string $relationship = 'lessons';

    protected static ?string $title = 'Уроки';

    public function form(Schema $schema): Schema
    {
        return LessonResource::form($schema);
    }

    public function table(Table $table): Table
    {
        return LessonResource::table($table)
            ->headerActions([
                CreateAction::make()->label('Додати урок'),
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
