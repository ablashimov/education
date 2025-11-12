<?php

namespace App\Actions\Group\Invites;

use App\Interfaces\Repositories\GroupInviteRepositoryInterface;

readonly class DeleteUserInvite
{
    public function __construct(private GroupInviteRepositoryInterface $repository)
    {
    }

    public function execute(int $groupId, int $organizationId): void
    {
        $invite = $this->repository->findOrganizationInvite($groupId, $organizationId);
        $this->repository->deleteModel($invite);
    }
}
