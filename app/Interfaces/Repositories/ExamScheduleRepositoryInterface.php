<?php

declare(strict_types=1);

namespace App\Interfaces\Repositories;

use Carbon\Carbon;
use Illuminate\Support\Collection;

interface ExamScheduleRepositoryInterface extends RepositoryInterface
{
    public function getNotAssignedExamsByDay(Carbon $date): Collection;
}
