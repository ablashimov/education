<?php

namespace App\Actions\Group\Exams\Instance;

use App\Interfaces\Repositories\ExamInstanceRepositoryInterface;
use Illuminate\Support\Collection;

readonly class GetExamInstances
{
    public function __construct(
        private ExamInstanceRepositoryInterface $repository,
    ) {
    }

    public function execute(int $groupId, int $assignedExamId, int $userId): Collection
    {
        return $this->repository->getByUser($groupId, $assignedExamId, $userId);
    }
}
