<?php

namespace App\Actions\Result;

use App\DTO\PaginateDTO;
use App\Interfaces\Repositories\ExamAssignmentRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

readonly class GetUserResults
{
    public function __construct(private ExamAssignmentRepositoryInterface $repository)
    {
    }

    public function execute(PaginateDTO $dto, int $userId, ?int $organizationId = null): LengthAwarePaginator
    {
        return $this->repository->getResults($dto, $userId, $organizationId);
    }
}
