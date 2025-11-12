<?php

namespace App\Actions\Group\Invites;

use App\Interfaces\Repositories\GroupInviteRepositoryInterface;
use App\Models\UserGroupInvite;
use Carbon\Carbon;

readonly class CreateUserInvite
{
    public function __construct(
        private GroupInviteRepositoryInterface $repository,
    ) {
    }

    public function execute(int $userId, int $groupId): UserGroupInvite
    {
        return $this->repository->create([
            'user_id' => $userId,
            'group_id' => $groupId,
            'invited_at' => Carbon::now(),
        ]);
    }
}
