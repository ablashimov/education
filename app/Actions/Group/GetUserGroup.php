<?php

namespace App\Actions\Group;

use App\Interfaces\Repositories\GroupRepositoryInterface;
use App\Models\Group;

readonly class GetUserGroup
{
    public function __construct(private GroupRepositoryInterface $repository)
    {
    }

    public function execute(int $id, int $userId): Group
    {
        return $this->repository->getUserGroup($id, $userId);
    }
}
