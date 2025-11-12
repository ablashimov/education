<?php

declare(strict_types=1);

namespace App\Interfaces\Repositories;

use App\DTO\PaginateDTO;
use App\Models\Lesson;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface LessonRepositoryInterface extends RepositoryInterface
{
    public function paginate(PaginateDTO $dto, int $moduleId, int $courseId): LengthAwarePaginator;
    public function getGroupLesson(int $lessonId, int $moduleId, int $courseId): Lesson;
}
