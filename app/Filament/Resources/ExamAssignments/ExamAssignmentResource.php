<?php

namespace App\Filament\Resources\ExamAssignments;

use App\Filament\Resources\ExamAssignments\Pages\CreateExamAssignment;
use App\Filament\Resources\ExamAssignments\Pages\EditExamAssignment;
use App\Filament\Resources\ExamAssignments\Pages\ListExamAssignments;
use App\Filament\Resources\ExamAssignments\RelationManagers\InstancesRelationManager;
use App\Filament\Resources\ExamAssignments\Schemas\ExamAssignmentForm;
use App\Filament\Resources\ExamAssignments\Tables\ExamAssignmentsTable;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ExamAssignmentResource extends Resource
{
    protected static string|null|\UnitEnum $navigationGroup = 'Екзамени';
    protected static ?string $navigationLabel = 'Призначені екзамени';
    protected static ?string $pluralLabel = 'Призначені екзамени';
    protected static ?string $modelLabel = 'Призначення екзамену';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentList;

    public static function form(Schema $schema): Schema
    {
        return ExamAssignmentForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ExamAssignmentsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            InstancesRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListExamAssignments::route('/'),
            'create' => CreateExamAssignment::route('/create'),
            'edit' => EditExamAssignment::route('/{record}/edit'),
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
