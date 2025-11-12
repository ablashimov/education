<?php

namespace App\Filament\Resources\ExamAssignments\Pages;

use App\Filament\Resources\ExamAssignments\ExamAssignmentResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListExamAssignments extends ListRecords
{
    protected static string $resource = ExamAssignmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
