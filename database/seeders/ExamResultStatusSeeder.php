<?php

namespace Database\Seeders;

use App\Enums\ExamResultStatusEnum;
use App\Models\ExamResultStatus;
use Illuminate\Database\Seeder;

class ExamResultStatusSeeder extends Seeder
{
    public function run(): void
    {
        foreach ($this->getStatuses() as $resultStatus) {
            ExamResultStatus::query()
                ->updateOrCreate(
                    attributes: ['slug' => $resultStatus['slug']],
                    values: $resultStatus
                );
        }
    }

    private function getStatuses(): array
    {
        return [
            [
                'name' => ExamResultStatusEnum:: ASSIGNED->title(),
                'slug' => ExamResultStatusEnum:: ASSIGNED,
            ],
            [
                'name' => ExamResultStatusEnum::IN_WORK->title(),
                'slug' => ExamResultStatusEnum::IN_WORK,
            ],
            [
                'name' => ExamResultStatusEnum::NOT_PASSED->title(),
                'slug' => ExamResultStatusEnum::NOT_PASSED,
            ],
            [
                'name' => ExamResultStatusEnum::PASSED->title(),
                'slug' => ExamResultStatusEnum::PASSED,
            ],
            [
                'name' => ExamResultStatusEnum::CHECKING->title(),
                'slug' => ExamResultStatusEnum::CHECKING,
            ],
        ];
    }
}
