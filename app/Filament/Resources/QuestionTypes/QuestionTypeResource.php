<?php

namespace App\Filament\Resources\QuestionTypes;

use App\Filament\Resources\QuestionTypes\Pages\EditQuestionType;
use App\Filament\Resources\QuestionTypes\Pages\ListQuestionTypes;
use App\Filament\Resources\QuestionTypes\Schemas\QuestionTypeForm;
use App\Filament\Resources\QuestionTypes\Tables\QuestionTypesTable;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class QuestionTypeResource extends Resource
{
    protected static string|null|\UnitEnum $navigationGroup = 'Екзамени';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedTag;
    protected static ?string $navigationLabel = 'Типи питань';
    protected static ?string $pluralLabel = 'Типи питань';
    protected static ?string $pluralModelLabel = 'Типи питань';
    protected static ?string $modelLabel = 'Тип питання';


    public static function form(Schema $schema): Schema
    {
        return QuestionTypeForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return QuestionTypesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListQuestionTypes::route('/'),
//            'create' => CreateQuestionType::route('/create'),
            'edit' => EditQuestionType::route('/{record}/edit'),
        ];
    }
}
