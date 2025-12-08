<?php

namespace App\Filament\Resources\ExamInstances;

use App\Filament\Resources\ExamInstances\Pages\CreateExamInstance;
use App\Filament\Resources\ExamInstances\Pages\EditExamInstance;
use App\Filament\Resources\ExamInstances\Pages\ListExamInstances;
use App\Filament\Resources\ExamInstances\RelationManagers\QuestionsRelationManager;
use App\Filament\Resources\ExamInstances\Schemas\ExamInstanceForm;
use App\Filament\Resources\ExamInstances\Tables\ExamInstancesTable;
use App\Models\ExamInstance;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ExamInstanceResource extends Resource
{
    protected static ?string $model = ExamInstance::class;

    protected static string|null|\UnitEnum $navigationGroup = 'Оцінювання';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedAcademicCap;

    protected static ?string $navigationLabel = 'Опитувальник';

    protected static ?string $pluralLabel = 'Опитувальники';

    protected static ?string $modelLabel = 'Опитувальники';

    public static function form(Schema $schema): Schema
    {
        return ExamInstanceForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ExamInstancesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            QuestionsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListExamInstances::route('/'),
            'create' => CreateExamInstance::route('/create'),
            'edit' => EditExamInstance::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
