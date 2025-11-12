<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Interfaces\Repositories\ExamScheduleRepositoryInterface;
use App\Models\GroupExamSchedule;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

readonly class ExamScheduleRepository extends AbstractRepository implements ExamScheduleRepositoryInterface
{
    public function getModel(): Model
    {
        return new GroupExamSchedule();
    }

    public function getNotAssignedExamsByDay(Carbon $date): Collection
    {
        return $this->getQuery()
            ->with(['exam'])
            ->whereBetween('start_at', [$date->startOfDay()->toIso8601String(), $date->endOfDay()->toIso8601String()])
            ->whereNotExists(function ($query) {
                $query->from('exam_assignments')
                    ->whereColumn('exam_assignments.group_id', 'group_exam_schedules.group_id')
                    ->whereColumn('exam_assignments.exam_id', 'group_exam_schedules.exam_id');
            })
            ->get();
    }

}
