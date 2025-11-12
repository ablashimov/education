<?php

namespace App\Actions\Group\Invites;

use App\DTO\PaginateDTO;
use App\Interfaces\Repositories\UserRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

readonly class PaginateAvailableUser
{
    public function __construct(
        private UserRepositoryInterface $repository,
    ) {
    }

    public function execute(PaginateDTO $dto, int $groupId): LengthAwarePaginator
    {
        return $this->repository->getForInvites($dto, $groupId);
    }
}
