<?php

namespace App\Actions\Group\Exams;

use App\Interfaces\Repositories\ExamResultStatusRepositoryInterface;
use Illuminate\Support\Collection;

readonly class GetExamResultStatuses
{
    public function __construct(
        private ExamResultStatusRepositoryInterface $repository,
    ) {
    }

    public function execute(): Collection
    {
        return $this->repository->getAll();
    }
}
