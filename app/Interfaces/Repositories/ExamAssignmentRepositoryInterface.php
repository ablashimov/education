<?php

declare(strict_types=1);

namespace App\Interfaces\Repositories;

use App\DTO\PaginateDTO;
use App\Models\ExamAssignment;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface ExamAssignmentRepositoryInterface extends RepositoryInterface
{
    public function getUserExam(int $groupId, int $assignedExamId, int $userId, array $with = []): ExamAssignment;

    public function getUserExams(int $userId, ?int $groupId = null, array $with = []): Collection;
    public function getResults(PaginateDTO $dto, bool $allResults): LengthAwarePaginator;

    public function getResult(int $assignedExamId, int $userId, ?int $adminOrganizationId = null);
}
