<?php

namespace App\Filament\Resources\ExamAttempts\Schemas;

use App\Models\ExamAttempt;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ExamAttemptInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('exam_instance_id')
                    ->numeric(),
                TextEntry::make('started_at')
                    ->dateTime(),
                TextEntry::make('submitted_at')
                    ->dateTime(),
                TextEntry::make('elapsed_seconds')
                    ->numeric(),
                TextEntry::make('score')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('graded_by')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('ip'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('deleted_at')
                    ->dateTime()
                    ->visible(fn (ExamAttempt $record): bool => $record->trashed()),
            ]);
    }
}
