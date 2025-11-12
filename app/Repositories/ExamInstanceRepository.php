<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Interfaces\Repositories\ExamInstanceRepositoryInterface;
use App\Models\ExamInstance;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

readonly class ExamInstanceRepository extends AbstractRepository implements ExamInstanceRepositoryInterface
{
    public function getModel(): Model
    {
        return new ExamInstance();
    }

    public function getByUser(int $groupId, int $assignedExamId, int $userId): Collection
    {
        return $this->getQuery()
            ->with('attempt')
            ->whereExists(function ($query) use ($groupId, $assignedExamId, $userId) {
                $query->from('exam_assignments')
                    ->where('exam_assignments.id', $assignedExamId)
                    ->where('exam_assignments.group_id', $groupId)
                    ->where('exam_assignments.user_id', $userId);
            })
            ->where('assignment_id', $assignedExamId)
            ->where('user_id', $userId)
            ->get();
    }
}
