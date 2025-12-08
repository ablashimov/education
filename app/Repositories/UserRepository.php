<?php

declare(strict_types=1);

namespace App\Repositories;

use App\DTO\PaginateDTO;
use App\Enums\RoleEnum;
use App\Interfaces\Repositories\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\AllowedFilter;

readonly class UserRepository extends AbstractRepository implements UserRepositoryInterface
{
    public function getAllowedFilters(): array
    {
        return [
            AllowedFilter::exact('id'),
            AllowedFilter::partial('name'),
            AllowedFilter::partial('email'),
        ];
    }

    public function getAllowedSorts(): array
    {
        return [
            'id',
            'name',
            'email',
            'rank',
            'created_at',
        ];
    }

    public function getModel(): Model
    {
        return new User();
    }

    public function getOranizationUsers(array $ids): Collection
    {
        return $this->getQuery()
            ->whereIn('id', $ids)
            ->organization()
            ->get();
    }

    public function getOrganizationAdmin(int $organizationId): ?User
    {
        return $this->getQuery()
            ->with(['roles', 'permissions'])
            ->whereHas('roles', function ($query) {
                $query->where('name', RoleEnum::ADMIN->value);
            })
            ->where('organization_id', $organizationId)
            ->first();
    }

    public function getGroupUsers(int $groupId): Collection
    {
        return $this->getQuery()
            ->select('users.*')
            ->join('user_groups', 'user_groups.user_id', '=', 'users.id')
            ->where('user_groups.group_id', $groupId)
            ->get();
    }

    public function getForInvites(PaginateDTO $dto, int $groupId): LengthAwarePaginator
    {
        return $this->getQuery()
            ->select('users.*')
            ->whereDoesntHave('groups', function ($query) use ($groupId) {
                $query->where('user_groups.group_id', $groupId);
            })
            ->whereDoesntHave('groupInvites', function ($query) use ($groupId) {
                $query->where('user_group_invites.group_id', $groupId);
            })
            ->organization()
            ->paginate($dto->perPage, ['*'], 'page', $dto->page);
    }

    public function getAdmins(): Collection
    {
        return $this->getQuery()
            ->with(['roles', 'permissions'])
            ->whereHas('roles', function ($query) {
                $query
                    ->withoutGlobalScopes()
                    ->where('name', RoleEnum::ADMIN->value);
            })
            ->get();
    }
}
