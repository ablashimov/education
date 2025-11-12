<?php

declare(strict_types=1);

namespace App\Repositories;

use App\DTO\PaginateDTO;
use App\Interfaces\Repositories\GroupRepositoryInterface;
use App\Models\Group;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;

readonly class GroupRepository extends AbstractRepository implements GroupRepositoryInterface
{
    public function getModel(): Model
    {
        return new Group;
    }

    public function paginateAvailable(PaginateDTO $dto, ?int $userId = null): LengthAwarePaginator
    {
        $query = $this->getQuery()
            ->with(['course', 'examSchedule'])
            ->whereHas('course', function ($query) {
                $query->where('is_available', true);
            })
            ->where('start_date', '>', Carbon::now()->endOfDay());

        $perPage = $dto->perPage;
        $this->addFilters($query);
        $this->trimPerPage($perPage, 200);

        return $query->paginate($perPage, ['*'], 'page', $dto->page);
    }


    public function getAvailable(int $id): Group
    {
        return $this->getQuery()
            ->with(['examSchedule.exam'])
            ->where('start_date', '>', Carbon::now()->endOfDay())
            ->where('id', $id)
            ->whereHas('course', function ($query) {
                $query->where('is_available', true);
            })
            ->firstOrFail();
    }


    public function paginateUserGroups(PaginateDTO $dto, int $userId): LengthAwarePaginator
    {
        $query = $this->getQuery()
            ->with(['course', 'examSchedule'])
            ->whereHas('course', function ($query) {
                $query->where('is_available', true);
            })
            ->whereExists(function ($query) use ($userId) {
                $query->from('user_groups')
                    ->whereColumn('user_groups.group_id', 'groups.id')
                    ->where('user_groups.user_id', $userId);
            })
            ->where('end_date', '>', Carbon::now()->endOfDay());

        $perPage = $dto->perPage;
        $this->addFilters($query);
        $this->trimPerPage($perPage, 200);

        return $query->paginate($perPage, ['*'], 'page', $dto->page);
    }

    public function getUserGroup(int $id, int $userId): Group
    {
        return $this->getQuery()
            ->with(['course.modules', 'examSchedule.exam'])
            ->where('start_date', '<=', Carbon::now())
            ->where('end_date', '>', Carbon::now())
            ->where('id', $id)
            ->whereHas('users', function ($query) use ($userId) {
                $query->where('users.id', $userId);
            })
            ->whereHas('course', function ($query) {
                $query->where('is_available', true);
            })
            ->firstOrFail();
    }

    public function isInvitePossible(int $id, int $userId): bool
    {
        return $this->getQuery()
            ->where('groups.start_date', '>', Carbon::now()->endOfDay())
            ->where('groups.id', $id)
            ->join('courses', 'groups.course_id', '=', 'courses.id')
            ->where('courses.is_available', true)
            ->whereNotExists(function ($query) use ($userId) {
                $query->from('user_group_invites')
                    ->whereColumn('user_group_invites.group_id', 'groups.id')
                    ->where('user_group_invites.user_id', $userId);
            })
            ->exists();
    }
}
