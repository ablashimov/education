<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Interfaces\Repositories\ForumCategoryRepositoryInterface;
use App\Models\ForumCategory;
use Illuminate\Database\Eloquent\Model;

readonly class ForumCategoryRepository extends AbstractRepository implements ForumCategoryRepositoryInterface
{
    public function getModel(): Model
    {
        return new ForumCategory;
    }
}
