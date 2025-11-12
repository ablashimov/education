<?php

namespace App\Filament\Resources\Exams\RelationManagers;

use Filament\Actions\AttachAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DetachAction;
use Filament\Actions\DetachBulkAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class QuestionsRelationManager extends RelationManager
{
    protected static string $relationship = 'questions';

    protected static ?string $title = 'Питання';
    protected static ?string $recordTitleAttribute = 'text';
    protected static ?string $modelLabel = 'Питання';

    protected static ?string $pluralModelLabel = 'Питання';

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('text')->label('Текст')->limit(60)->wrap()->searchable(),
                TextColumn::make('type.name')->label('Тип')->sortable(),
            ])
            ->headerActions([
                AttachAction::make()
                    ->multiple()
                    ->preloadRecordSelect()
                    ->chunkSelectedRecords(50)
                    ->record(fn() => $this->ownerRecord)
                    ->recordSelectOptionsQuery(function (Builder $query, $livewire) {
                        $exam = $livewire->ownerRecord;
                        $query
                            ->whereDoesntHave('exams', fn($q) => $q->where('exams.id', $exam->id));
                    }),
            ])
            ->recordActions([
                DetachAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DetachBulkAction::make(),
                ]),
            ]);
    }
}
