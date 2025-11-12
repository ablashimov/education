<?php

namespace App\Actions\Group\Exams\Instance;

use App\Interfaces\Repositories\AttemptRepositoryInterface;
use App\Models\ExamAttempt;

readonly class GetExamInstanceResult
{
    public function __construct(private AttemptRepositoryInterface $repository)
    {
    }

    public function execute(int $instanceId, int $attemptId): ExamAttempt
    {
        return $this->repository->findBy(
            ['id' => $attemptId, 'exam_instance_id' => $instanceId],
            ['answers.question.type', 'answers.question.choices', 'answers.choices']
        );
    }
}
