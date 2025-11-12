<?php

declare(strict_types=1);

namespace App\Interfaces\Repositories;

use App\Models\User;
use Illuminate\Support\Collection;

interface ExamQuestionRepositoryInterface extends RepositoryInterface
{
    public function getRandom(int $count, int $examId): Collection;
}
