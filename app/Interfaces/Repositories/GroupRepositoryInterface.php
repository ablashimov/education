<?php

declare(strict_types=1);

namespace App\Interfaces\Repositories;

use App\DTO\PaginateDTO;
use App\Models\Group;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface GroupRepositoryInterface extends RepositoryInterface
{
    public function paginateAvailable(PaginateDTO $dto, ?int $userId = null): LengthAwarePaginator;
    public function paginateUserGroups(PaginateDTO $dto, int $userId): LengthAwarePaginator;

    public function getAvailable(int $id): Group;

    public function getUserGroup(int $id, int $userId);
}
