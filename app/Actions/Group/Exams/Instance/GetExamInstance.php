<?php

namespace App\Actions\Group\Exams\Instance;

use App\Interfaces\Repositories\ExamInstanceRepositoryInterface;
use App\Models\ExamInstance;

readonly class GetExamInstance
{
    public function __construct(private ExamInstanceRepositoryInterface $repository)
    {
    }

    public function execute(int $assignedExamId, int $userId): ExamInstance
    {
        return $this->repository->findBy(
            ['id' => $assignedExamId, 'user_id' => $userId],
            ['questions.type', 'questions.choices', 'attempt.answers']
        );
    }
}
