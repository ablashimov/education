<?php

namespace App\Filament\Resources\ExamAttempts\Pages;

use App\Filament\Resources\ExamAttempts\ExamAttemptResource;
use Filament\Resources\Pages\ViewRecord;
use Filament\Support\Enums\Width;

class ViewExamAttempt extends ViewRecord
{
    protected static string $resource = ExamAttemptResource::class;

    protected Width | string | null $maxContentWidth = Width::Full;
    protected function getHeaderWidgets(): array
    {
        return [];
    }

    protected string $view = 'filament.exam-attempt';
}
