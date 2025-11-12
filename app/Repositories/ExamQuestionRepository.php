<?php

declare(strict_types=1);

namespace App\Repositories;

use App\DTO\PaginateDTO;
use App\Interfaces\Repositories\ModuleRepositoryInterface;
use App\Interfaces\Repositories\ExamQuestionRepositoryInterface;
use App\Models\ExamQuestion;
use App\Models\Module;
use App\Models\Question;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

readonly class ExamQuestionRepository extends AbstractRepository implements ExamQuestionRepositoryInterface
{
    public function getModel(): Model
    {
        return new ExamQuestion();
    }

    public function getRandom(int $count, int $examId): Collection
    {
        return $this->getQuery()
            ->where('exam_id', $examId)
            ->inRandomOrder()
            ->take($count)
            ->get();
    }
}
