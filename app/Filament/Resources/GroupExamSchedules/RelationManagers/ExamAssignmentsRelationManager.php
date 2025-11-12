<?php

namespace App\Filament\Resources\GroupExamSchedules\RelationManagers;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ExamAssignmentsRelationManager extends RelationManager
{
    protected static string $relationship = 'examAssignments';

    protected static ?string $title = 'Призначення екзаменів';
    protected static ?string $modelLabel = 'Призначити екзамен';
    protected static ?string $pluralModelLabel = 'Призначення екзаменів';

    public function form(Schema $schema): Schema
    {
        $record = $this->getOwnerRecord();

        return $schema->components([
            Forms\Components\Select::make('user_id')
                ->label('Користувач')
                ->relationship(
                    'user',
                    'email',
                    modifyQueryUsing: function (Builder $query) use ($record) {
                        $query->whereHas('groups', fn($q) => $q->where('groups.id', $record->group_id));
                    }
                )
                ->searchable()
                ->preload()
                ->optionsLimit(20)
                ->nullable(),
            Forms\Components\Select::make('exam_result_status_id')
                ->label('Статус здачі екзамену')
                ->relationship('resultStatus', 'name')
                ->searchable()
                ->preload()
                ->nullable(),
            Forms\Components\TextInput::make('attempts_allowed')
                ->label('К-сть спроб')->numeric()->required(),
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
//                TextColumn::make('exam.title')->label('Екзамен')->searchable(),
                TextColumn::make('user.email')->label('Користувач')->searchable(),
                TextColumn::make('attempts_allowed')->label('Спроб')->sortable(),
            ])
            ->headerActions([
                CreateAction::make()->label('Додати призначення'),
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
