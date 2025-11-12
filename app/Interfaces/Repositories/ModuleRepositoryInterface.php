<?php

declare(strict_types=1);

namespace App\Interfaces\Repositories;

use App\DTO\PaginateDTO;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ModuleRepositoryInterface extends RepositoryInterface
{
    public function paginate(PaginateDTO $dto, int $courseId): LengthAwarePaginator;
}
