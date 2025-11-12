<?php

declare(strict_types=1);

namespace App\Repositories;

use App\DTO\PaginateDTO;
use App\Interfaces\Repositories\ExamResultStatusRepositoryInterface;
use App\Interfaces\Repositories\ExamScheduleRepositoryInterface;
use App\Interfaces\Repositories\ModuleRepositoryInterface;
use App\Interfaces\Repositories\ExamQuestionRepositoryInterface;
use App\Models\ExamQuestion;
use App\Models\ExamResultStatus;
use App\Models\GroupExamSchedule;
use App\Models\Module;
use App\Models\Question;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

readonly class ExamResultStatusRepository extends AbstractRepository implements ExamResultStatusRepositoryInterface
{
    public function getModel(): Model
    {
        return new ExamResultStatus();
    }
}
