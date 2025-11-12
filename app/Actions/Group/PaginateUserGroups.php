<?php

namespace App\Actions\Group;

use App\DTO\PaginateDTO;
use App\Interfaces\Repositories\GroupRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

readonly class PaginateUserGroups
{
    public function __construct(private GroupRepositoryInterface $repository)
    {
    }

    public function execute(PaginateDTO $dto, int $userId): LengthAwarePaginator
    {
        return $this->repository->paginateUserGroups($dto, $userId);
    }
}
