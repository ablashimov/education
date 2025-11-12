<?php

declare(strict_types=1);

namespace App\Repositories;

use App\DTO\PaginateDTO;
use App\Interfaces\Repositories\LessonRepositoryInterface;
use App\Models\Lesson;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;

readonly class LessonRepository extends AbstractRepository implements LessonRepositoryInterface
{
    public function getModel(): Model
    {
        return new Lesson();
    }

    public function paginate(PaginateDTO $dto, int $moduleId, int $courseId): LengthAwarePaginator
    {
        $query = $this->getQuery()
            ->whereHas('module', function ($query) use ($moduleId, $courseId) {
                $query->where('id', $moduleId)
                    ->where('course_id', $courseId);
            });

        $perPage = $dto->perPage;
        $this->addFilters($query);
        $this->trimPerPage($perPage, 200);

        return $query->paginate($perPage, ['*'], 'page', $dto->page);
    }

    public function getGroupLesson(int $lessonId, int $moduleId, int $courseId): Lesson
    {
        return $this->getQuery()
            ->where('id', $lessonId)
            ->with('files')
            ->whereHas('module', function ($query) use ($moduleId, $courseId) {
                $query->where('id', $moduleId)
                    ->where('course_id', $courseId);
            })
            ->firstOrFail();
    }
}
