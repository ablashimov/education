<?php

declare(strict_types=1);

namespace App\Repositories;

use App\DTO\PaginateDTO;
use App\Interfaces\Repositories\GroupInviteRepositoryInterface;
use App\Models\UserGroupInvite;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;

readonly class GroupInviteRepository extends AbstractRepository implements GroupInviteRepositoryInterface
{
    public function getModel(): Model
    {
        return new UserGroupInvite();
    }

    public function paginate(PaginateDTO $dto, int $groupId): LengthAwarePaginator
    {
        $query = $this->getQuery()
            ->select('user_group_invites.*')
            ->with('user')
            ->where('group_id', $groupId)
            ->join('users', 'user_group_invites.user_id', '=', 'users.id')
            ->where('users.organization_id', $dto->organizationId);

        $perPage = $dto->perPage;
        $this->addFilters($query);
        $this->trimPerPage($perPage, 200);

        return $query->paginate($perPage, ['*'], 'page', $dto->page);
    }

    public function findOrganizationInvite(int $id, int $organizationId): UserGroupInvite
    {
        return $this->getQuery()
            ->select('user_group_invites.*')
            ->where('user_group_invites.id', $id)
            ->join('users', 'user_group_invites.user_id', '=', 'users.id')
            ->where('users.organization_id', $organizationId)
            ->firstOrFail();
    }
}
