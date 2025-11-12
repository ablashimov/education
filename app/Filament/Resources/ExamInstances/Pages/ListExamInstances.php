<?php

namespace App\Filament\Resources\ExamInstances\Pages;

use App\Filament\Resources\ExamInstances\ExamInstanceResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListExamInstances extends ListRecords
{
    protected static string $resource = ExamInstanceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
