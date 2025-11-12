<?php

namespace App\Actions\Group\Exams;

use App\Interfaces\Repositories\ExamAssignmentRepositoryInterface;
use App\Models\ExamAssignment;

readonly class GetAssignedExam
{
    public function __construct(
        private ExamAssignmentRepositoryInterface $repository,
    ) {
    }

    public function execute(int $groupId, int $assignedExamId, int $userId): ExamAssignment
    {
        return $this->repository->getUserExam(
            $groupId,
            $assignedExamId,
            $userId,
            ['exam', 'instances.attempt.answers', 'resultStatus']
        );
    }
}
