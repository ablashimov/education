<?php

namespace App\Actions\Group\Module\Lesson;

use App\Interfaces\Repositories\LessonRepositoryInterface;
use App\Models\Lesson;

readonly class GetLesson
{
    public function __construct(
        private LessonRepositoryInterface $repository,
    ) {
    }

    public function execute(int $moduleId, int $lessonId, int $courseId): Lesson
    {
        return $this->repository->getGroupLesson($lessonId, $moduleId, $courseId);
    }
}
