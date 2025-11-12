<?php

namespace App\Actions\Group\Module;

use App\DTO\PaginateDTO;
use App\Interfaces\Repositories\ModuleRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

readonly class PaginateModules
{
    public function __construct(
        private ModuleRepositoryInterface $repository,
    ) {
    }

    public function execute(PaginateDTO $dto, int $courseId): LengthAwarePaginator
    {
        return $this->repository->paginate($dto, $courseId);
    }
}
