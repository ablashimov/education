<?php

namespace App\Filament\Resources\GroupExamSchedules\Pages;

use App\Filament\Resources\GroupExamSchedules\GroupExamScheduleResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditGroupExamSchedule extends EditRecord
{
    protected static string $resource = GroupExamScheduleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    public function hasCombinedRelationManagerTabsWithContent(): bool
    {
        return true;
    }
}
