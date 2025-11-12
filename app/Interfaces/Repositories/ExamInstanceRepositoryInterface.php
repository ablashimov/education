<?php

declare(strict_types=1);

namespace App\Interfaces\Repositories;

use Illuminate\Support\Collection;

interface ExamInstanceRepositoryInterface extends RepositoryInterface
{
    public function getByUser(int $groupId, int $assignedExamId, int $userId): Collection;
}
