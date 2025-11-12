<?php

namespace App\Filament\Resources\Users\Tables;

use App\Filament\Resources\Organizations\RelationManagers\UsersRelationManager;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('name')
                    ->label('Прізвище, ім`я, по батькові')
                    ->searchable(),
                TextColumn::make('email')
                    ->label('Email'),
                TextColumn::make('rank')
                    ->label('Звання')
                    ->searchable(),
                TextColumn::make('organization.name')
                    ->label('Організація')
                    ->hiddenOn(UsersRelationManager::class)
                    ->searchable(),
                TextColumn::make('status.name')
                    ->label('Статус')
                    ->sortable(),
                TextColumn::make('email_verified_at')
                    ->label('Email верифіковано')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('created_by')
                    ->label('Створено')
                    ->numeric()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Дата створення')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('Дата оновлення')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('last_login_at')
                    ->label('Останній вхід')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('deleted_at')
                    ->label('Видалено')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}
