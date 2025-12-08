<?php

namespace App\Actions\Result;

use App\DTO\PaginateDTO;
use App\Interfaces\Repositories\ExamAssignmentRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

readonly class GetUserResults
{
    public function __construct(private ExamAssignmentRepositoryInterface $repository)
    {
    }

    public function execute(PaginateDTO $dto, bool $allResults): LengthAwarePaginator
    {
        return $this->repository->getResults($dto, $allResults);
    }
}
