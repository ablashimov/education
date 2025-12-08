<?php

namespace App\Actions\Forum;

use App\Interfaces\Repositories\ForumCategoryRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

readonly class GetForumCategories
{
    public function __construct(
        private ForumCategoryRepositoryInterface $repository
    ) {}

    public function execute(): Collection
    {
        return $this->repository->getAll();
    }
}
