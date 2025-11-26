<?php

declare(strict_types=1);

namespace App\Repositories;

use App\DTO\PaginateDTO;
use App\Interfaces\Repositories\ExamAssignmentRepositoryInterface;
use App\Models\ExamAssignment;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\AllowedFilter;

readonly class ExamAssignmentRepository extends AbstractRepository implements ExamAssignmentRepositoryInterface
{
    public function getAllowedFilters(): array
    {
        return [
            AllowedFilter::partial('exam.title'),
            AllowedFilter::partial('group.name'),
            AllowedFilter::partial('user.name'),
            AllowedFilter::partial('user.email'),
        ];
    }

    public function getAllowedSorts(): array
    {
        return [
            'user.name',
            'user.email',
            'exam.title',
            'group.name',
            'end_at',
            'created_at',
        ];
    }

    public function getModel(): Model
    {
        return new ExamAssignment();
    }

    public function getUserExam(int $groupId, int $assignedExamId, int $userId, array $with = []): ExamAssignment
    {
        return $this->getQuery()
            ->with($with)
            ->where('group_id', $groupId)
            ->where('id', $assignedExamId)
            ->where('user_id', $userId)
            ->firstOrFail();
    }

    public function getUserExams(int $userId, ?int $groupId = null, array $with = []): Collection
    {
        return $this->getQuery()
            ->with($with)
            ->when($groupId, fn($q) => $q->where('group_id', $groupId))
            ->where('user_id', $userId)
//            ->where('start_at', '>=', Carbon::now())
//            ->where('end_at', '<=', Carbon::now())
            ->get();
    }

    public function getResults(PaginateDTO $dto, int $userId, ?int $organizationId = null): LengthAwarePaginator
    {
        $with = ['exam', 'group', 'resultStatus', 'attempts'];
        if ($organizationId) {
            $with[] = 'user';
        }
        $query = $this->getQuery()
            ->with($with);

        if ($organizationId) {
            $query->whereHas('user', function ($query) use ($organizationId) {
                $query->where('users.organization_id', $organizationId);
            });
        } else {
            $query->where('user_id', $userId);
        }

        $perPage = $dto->perPage;
        $this->addFilters($query);
        $this->trimPerPage($perPage, 200);

        return $query->paginate($perPage, ['*'], 'page', $dto->page);
    }

    public function getResult(int $assignedExamId, int $userId): ExamAssignment
    {
        return $this->getQuery()
            ->with(['exam', 'group', 'resultStatus', 'attempts', 'instances.attempt.answers'])
            ->where('id', $assignedExamId)
            ->where('user_id', $userId)
            ->firstOrFail();
    }
}
