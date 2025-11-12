<?php

namespace App\Filament\Resources\Groups\RelationManagers;

use Carbon\Carbon;
use Filament\Actions\AttachAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DetachAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class UsersRelationManager extends RelationManager
{
    protected static string $relationship = 'users';

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $title = 'Користувачі';

    protected static ?string $modelLabel = 'Користувач';

    protected static ?string $pluralModelLabel = 'Користувачі';

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('ID')->numeric()->sortable(),
                TextColumn::make('name')->label('Імʼя')->searchable(),
                TextColumn::make('email')->label('Email')->searchable(),
                TextColumn::make('pivot.joined_at')->label('Приєднався')->dateTime(),
            ])
            ->headerActions([
                AttachAction::make()
                    ->preloadRecordSelect()
                    ->chunkSelectedRecords(50)
                    ->record(fn () => $this->ownerRecord)
                    ->recordSelectOptionsQuery(function (Builder $query, $livewire) {
                        $group = $livewire->ownerRecord;
                        $query
                            ->whereDoesntHave('groups', fn ($q) => $q->where('groups.id', $group->id))
                            ->whereNotNull('organization_id');
                    })
                    ->schema(fn (AttachAction $action): array => [
                        $action->getRecordSelect(),
                        DateTimePicker::make('joined_at')->default(Carbon::now()),
                    ]),
            ])
            ->recordActions([
                DetachAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DetachAction::make(),
                ]),
            ]);
    }
}
