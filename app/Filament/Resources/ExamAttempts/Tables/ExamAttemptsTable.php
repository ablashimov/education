<?php

namespace App\Filament\Resources\ExamAttempts\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class ExamAttemptsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('exam_instance_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('started_at')
                    ->label('Дата початку спроби')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('submitted_at')
                    ->label('Дата відправки результату')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('elapsed_seconds')
                    ->label('Кількість витрачених секунд')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('score')
                    ->label('Оцінка')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('graded_by')
                    ->label('Оцінювач')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('ip'),
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
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}
