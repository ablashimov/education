<?php

namespace App\Filament\Resources\GroupExamSchedules\Pages;

use App\Filament\Resources\GroupExamSchedules\GroupExamScheduleResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListGroupExamSchedules extends ListRecords
{
    protected static string $resource = GroupExamScheduleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
