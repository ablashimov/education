<?php

namespace App\Actions\Group\Module;

use App\DTO\PaginateDTO;
use App\Interfaces\Repositories\ModuleRepositoryInterface;
use App\Models\Module;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

readonly class GetModule
{
    public function __construct(
        private ModuleRepositoryInterface $repository,
    ) {
    }

    public function execute(int $courseId, int $moduleId): Module
    {
        return $this->repository
            ->findBy(
                ['id' => $moduleId, 'course_id' => $courseId],
                ['lessons']
            );
    }
}
