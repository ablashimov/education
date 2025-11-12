<?php

namespace App\Actions\User;

use App\DTO\PaginateDTO;
use App\Interfaces\Repositories\UserRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

readonly class PaginateUsers
{
    public function __construct(private UserRepositoryInterface $repository)
    {
    }

    public function execute(PaginateDTO $dto): LengthAwarePaginator
    {
        return $this->repository->paginateAll(
            $dto->page,
            $dto->perPage,
            with: ['roles'],
            where: ['organization_id' => $dto->organizationId]
        );
    }
}
