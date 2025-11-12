<?php

namespace App\Actions\Group\Module\Lesson;

use App\DTO\PaginateDTO;
use App\Interfaces\Repositories\LessonRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

readonly class PaginateLessons
{
    public function __construct(
        private LessonRepositoryInterface $repository,
    ) {
    }

    public function execute(PaginateDTO $dto, int $moduleId, int $courseId): LengthAwarePaginator
    {
        return $this->repository->paginate($dto, $moduleId, $courseId);
    }
}
