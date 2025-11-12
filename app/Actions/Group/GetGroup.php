<?php

namespace App\Actions\Group;

use App\Interfaces\Repositories\GroupRepositoryInterface;
use App\Models\Group;

readonly class GetGroup
{
    public function __construct(private GroupRepositoryInterface $repository)
    {
    }

    public function execute(int $id): Group
    {
        return $this->repository->getAvailable($id);
    }
}
