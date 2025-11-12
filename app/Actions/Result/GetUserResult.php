<?php

namespace App\Actions\Result;

use App\Interfaces\Repositories\ExamAssignmentRepositoryInterface;
use App\Models\ExamAssignment;

readonly class GetUserResult
{
    public function __construct(private ExamAssignmentRepositoryInterface $repository)
    {
    }

    public function execute(int $assignedExamId, int $userId): ExamAssignment
    {
        return $this->repository->getResult($assignedExamId, $userId);
    }
}
