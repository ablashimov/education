<?php

declare(strict_types=1);

namespace App\Repositories;

use App\DTO\PaginateDTO;
use App\Interfaces\Repositories\ModuleRepositoryInterface;
use App\Models\Module;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;

readonly class ModuleRepository extends AbstractRepository implements ModuleRepositoryInterface
{
    public function getModel(): Model
    {
        return new Module();
    }

    public function paginate(PaginateDTO $dto, int $courseId): LengthAwarePaginator
    {
        $query = $this->getQuery()
            ->where('course_id', $courseId);

        $perPage = $dto->perPage;
        $this->addFilters($query);
        $this->trimPerPage($perPage, 200);

        return $query->paginate($perPage, ['*'], 'page', $dto->page);
    }
}
