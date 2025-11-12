<?php

namespace App\Actions\Group;

use App\DTO\PaginateDTO;
use App\Interfaces\Repositories\GroupRepositoryInterface;
use App\Interfaces\Repositories\UserRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

readonly class PaginateAvailableGroups
{
    public function __construct(private GroupRepositoryInterface $repository)
    {
    }

    public function execute(PaginateDTO $dto): LengthAwarePaginator
    {
        return $this->repository->paginateAvailable($dto);
    }
}
