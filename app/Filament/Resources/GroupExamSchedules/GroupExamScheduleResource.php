<?php

namespace App\Filament\Resources\GroupExamSchedules;

use App\Filament\Resources\GroupExamSchedules\Pages\CreateGroupExamSchedule;
use App\Filament\Resources\GroupExamSchedules\Pages\EditGroupExamSchedule;
use App\Filament\Resources\GroupExamSchedules\Pages\ListGroupExamSchedules;
use App\Filament\Resources\GroupExamSchedules\RelationManagers\ExamAssignmentsRelationManager;
use App\Filament\Resources\GroupExamSchedules\Schemas\GroupExamScheduleForm;
use App\Filament\Resources\GroupExamSchedules\Tables\GroupExamSchedulesTable;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class GroupExamScheduleResource extends Resource
{
    protected static string|null|\UnitEnum $navigationGroup = 'Екзамени';
    protected static ?string $navigationLabel = 'Планування екзаменів';

    protected static ?string $modelLabel = 'Планування екзамену';
    protected static ?string $pluralLabel = 'Планування екзаменів';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCalendarDays;

    protected static bool $shouldRegisterNavigation = false;

    public static function form(Schema $schema): Schema
    {
        return GroupExamScheduleForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return GroupExamSchedulesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            ExamAssignmentsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListGroupExamSchedules::route('/'),
            'create' => CreateGroupExamSchedule::route('/create'),
            'edit' => EditGroupExamSchedule::route('/{record}/edit'),
        ];
    }
}
