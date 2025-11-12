<?php

namespace App\Actions\Group\Exams;

use App\Interfaces\Repositories\ExamScheduleRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Collection;

readonly class GetScheduledExams
{
    public function __construct(
        private ExamScheduleRepositoryInterface $repository,
    ) {
    }

    public function execute(Carbon $date): Collection
    {
        return $this->repository->getNotAssignedExamsByDay($date);
    }
}
