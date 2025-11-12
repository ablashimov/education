<?php

namespace App\Actions\Group\Invites;

use App\DTO\PaginateDTO;
use App\Interfaces\Repositories\GroupInviteRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

readonly class PaginateUserInvites
{
    public function __construct(
        private GroupInviteRepositoryInterface $repository,
    ) {
    }

    public function execute(PaginateDTO $dto, int $groupId): LengthAwarePaginator
    {
        return $this->repository->paginate($dto, $groupId);
    }
}
