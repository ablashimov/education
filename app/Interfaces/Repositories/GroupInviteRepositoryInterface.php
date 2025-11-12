<?php

declare(strict_types=1);

namespace App\Interfaces\Repositories;

use App\DTO\PaginateDTO;
use App\Models\UserGroupInvite;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface GroupInviteRepositoryInterface extends RepositoryInterface
{
    public function paginate(PaginateDTO $dto, int $groupId): LengthAwarePaginator;

    public function findOrganizationInvite(int $id, int $organizationId): UserGroupInvite;
}
