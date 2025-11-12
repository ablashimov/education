<?php

namespace App\Filament\Resources\ExamAssignments\Pages;

use App\Filament\Resources\ExamAssignments\ExamAssignmentResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditExamAssignment extends EditRecord
{
    protected static string $resource = ExamAssignmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
//            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }

    public function hasCombinedRelationManagerTabsWithContent(): bool
    {
        return true;
    }
}
