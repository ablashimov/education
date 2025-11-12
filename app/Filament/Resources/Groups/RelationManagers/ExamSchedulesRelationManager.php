<?php

namespace App\Filament\Resources\Groups\RelationManagers;

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

class ExamSchedulesRelationManager extends RelationManager
{
    protected static string $relationship = 'examSchedule';

    protected static ?string $title = 'Планування екзаменів для групи';

    protected static ?string $modelLabel = 'Планування екзамену';
    protected static ?string $pluralModelLabel = 'Планування екзаменів';

    public function form(Schema $schema): Schema
    {
        $record = $this->getOwnerRecord();

        return $schema->components([
            Forms\Components\Select::make('exam_id')
                ->label('Екзамен')
                ->relationship(
                    'exam',
                    'title',
                    modifyQueryUsing: function (Builder $query) use ($record) {
                        $query->where('course_id', $record->course_id);
                    })
                ->required()
                ->preload()
                ->optionsLimit(20)
                ->searchable(),
            Forms\Components\DateTimePicker::make('start_at')
                ->format('Y-m-d H:i')
                ->label('Початок')
                ->required(),
            Forms\Components\DateTimePicker::make('end_at')
                ->format('Y-m-d H:i')
                ->label('Кінець')
                ->required(),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('exam.title')->label('Екзамен')->searchable(),
                TextColumn::make('start_at')->label('Початок')->dateTime()->sortable(),
                TextColumn::make('end_at')->label('Кінець')->dateTime()->sortable(),
            ])
            ->headerActions([
                CreateAction::make()->label('Додати запис'),
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
