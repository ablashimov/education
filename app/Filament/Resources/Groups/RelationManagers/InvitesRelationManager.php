<?php

namespace App\Filament\Resources\Groups\RelationManagers;

use Filament\Actions\Action;
use Filament\Actions\AttachAction;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class InvitesRelationManager extends RelationManager
{
    protected static string $relationship = 'invites';
    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $title = 'Користувачі на розгляд';

    protected static ?string $modelLabel = 'Користувач';

    protected static ?string $pluralModelLabel = 'Користувачі на розгляд';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->label('Користувач')
                    ->relationship('user', 'name')
                    ->required(),
                DateTimePicker::make('invited_at')
                    ->label('Запрошено')
                    ->required(),
                DateTimePicker::make('accepted_at')
                    ->label('Принято'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('user.name')
            ->columns([
                TextColumn::make('user.name')
                    ->label('Користувач')
                    ->searchable(),
                TextColumn::make('invited_at')
                    ->label('Запрошено')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('accepted_at')
                    ->label('Принято')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make(),
                AttachAction::make(),
            ])
            ->recordActions([
                Action::make('accept')
                    ->label('Прийняти')
                    ->icon('heroicon-o-check')
                    ->color('success')
                    ->action(function ($record) {
                        $record->update(['accepted_at' => now()]);

                        // Create entry in user_groups
                        $record->group->users()->attach($record->user_id, ['joined_at' => now()]);

                        Notification::make()
                            ->title('Запрошення прийнято')
                            ->success()
                            ->send();
                    })
                    ->visible(fn ($record) => is_null($record->accepted_at)),
                //                EditAction::make(),
                //                DetachAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    BulkAction::make('acceptSelected')
                        ->label('Прийняти вибрані')
                        ->icon('heroicon-o-check')
                        ->color('success')
                        ->action(function ($records) {
                            $now = now();
                            foreach ($records as $record) {
                                if (is_null($record->accepted_at)) {
                                    $record->update(['accepted_at' => $now]);
                                    $record->group->users()->attach($record->user_id, ['joined_at' => $now]);
                                }
                            }

                            Notification::make()
                                ->title('Вибрані запрошення прийнято')
                                ->success()
                                ->send();
                        })
                        ->deselectRecordsAfterCompletion(),
//                    DetachBulkAction::make(),
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
