<?php

namespace App\Actions\Group\Exams;

use App\Interfaces\Repositories\ExamAssignmentRepositoryInterface;
use Illuminate\Support\Collection;

readonly class GetUserGroupAssignedExams
{
    public function __construct(
        private ExamAssignmentRepositoryInterface $repository,
    ) {
    }

    public function execute(int $userId, ?int $groupId = null): Collection
    {
        return $this->repository->getUserExams($userId, $groupId, ['exam']);
    }
}
