<?php

namespace App\Filament\Resources\Groups;

use App\Filament\Resources\Groups\Pages\CreateGroup;
use App\Filament\Resources\Groups\Pages\EditGroup;
use App\Filament\Resources\Groups\Pages\ListGroups;
use App\Filament\Resources\Groups\RelationManagers\ExamAssignmentsRelationManager;
use App\Filament\Resources\Groups\RelationManagers\ExamSchedulesRelationManager;
use App\Filament\Resources\Groups\RelationManagers\InvitesRelationManager;
use App\Filament\Resources\Groups\RelationManagers\UsersRelationManager;
use App\Filament\Resources\Groups\Schemas\GroupForm;
use App\Filament\Resources\Groups\Tables\GroupsTable;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class GroupResource extends Resource
{
    protected static string|null|\UnitEnum $navigationGroup = 'Управління';
    protected static ?string $navigationLabel = 'Групи';
    protected static ?string $pluralLabel = 'Групи';
    protected static ?string $pluralModelLabel = 'Групи';
    protected static ?string $modelLabel = 'Група';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserGroup;

    public static function form(Schema $schema): Schema
    {
        return GroupForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return GroupsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            UsersRelationManager::class,
            ExamSchedulesRelationManager::class,
            InvitesRelationManager::class,
            ExamAssignmentsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListGroups::route('/'),
            'create' => CreateGroup::route('/create'),
            'edit' => EditGroup::route('/{record}/edit'),
        ];
    }
}
