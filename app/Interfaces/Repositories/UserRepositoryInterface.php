<?php

declare(strict_types=1);

namespace App\Interfaces\Repositories;

use App\DTO\PaginateDTO;
use App\Models\User;
use Illuminate\Support\Collection;

interface UserRepositoryInterface extends RepositoryInterface
{
    public function getOranizationUsers(array $ids): Collection;

    public function getOrganizationAdmin(int $organizationId): ?User;
    public function getGroupUsers(int $groupId): Collection;

    public function getForInvites(PaginateDTO $dto, int $groupId);

    public function getAdmins(): Collection;
}
