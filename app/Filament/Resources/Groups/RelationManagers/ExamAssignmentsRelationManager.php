<?php

namespace App\Filament\Resources\Groups\RelationManagers;

use Filament\Actions\AssociateAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DissociateAction;
use Filament\Actions\DissociateBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ExamAssignmentsRelationManager extends RelationManager
{
    protected static string $relationship = 'examAssignments';

    protected static ?string $title = 'Призначені екзамени';

    protected static ?string $modelLabel = 'Призначити екзамен';

    protected static ?string $pluralModelLabel = 'Призначені екзамени';

    public function form(Schema $schema): Schema
    {
        $record = $this->getOwnerRecord();

        return $schema
            ->components([
                Hidden::make('exam_id')
                    ->default($record->examSchedule->exam_id)
                ->required(),
                Select::make('user_id')
                    ->label('Користувач')
                    ->relationship(
                        'user',
                        'email',
                        modifyQueryUsing: function (Builder $query) use ($record) {
                            $query->whereHas('groups', fn ($q) => $q->where('groups.id', $record->id));
                        }
                    )->searchable()
                    ->preload()
                    ->optionsLimit(20)
                    ->nullable(),
                Select::make('exam_result_status_id')
                    ->label('Статус здачі екзамену')
                    ->relationship('resultStatus', 'name')
                    ->searchable()
                    ->preload()
                    ->nullable(),
                TextInput::make('attempts_allowed')
                    ->label('К-сть спроб')->numeric()->required(),
                Toggle::make('is_control')
                    ->label('Контрольний тест')
                    ->required(),
                DateTimePicker::make('start_at')->label("Дата початку"),
                DateTimePicker::make('end_at')->label("Дата закінчення"),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('user.name')
            ->columns([
                TextColumn::make('exam.title')
                    ->label('Назва екзамену')
                    ->searchable(),
                TextColumn::make('user.name')
                    ->label('Користувач')
                    ->searchable(),
                TextColumn::make('exam_result_status_id')
                    ->label('Статус здачі екзамену')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('attempts_allowed')
                    ->label('К-сть спроб')
                    ->numeric()
                    ->sortable(),
                IconColumn::make('is_control')
                    ->label('Контрольний тест')
                    ->boolean(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('start_at')
                    ->label("Дата початку")
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('end_at')
                    ->label("Дата закінчення")
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->headerActions([
                CreateAction::make(),
                AssociateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DissociateAction::make(),
                DeleteAction::make(),
                ForceDeleteAction::make(),
                RestoreAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DissociateBulkAction::make(),
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ])
            ->modifyQueryUsing(fn (Builder $query) => $query
                ->withoutGlobalScopes([
                    SoftDeletingScope::class,
                ]));
    }
}
