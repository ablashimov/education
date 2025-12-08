<?php

declare(strict_types=1);

namespace App\Interfaces\Repositories;

use App\Models\ForumTopic;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ForumTopicRepositoryInterface extends RepositoryInterface
{
    public function paginate(array $filters, int $perPage = 15): LengthAwarePaginator;
    
    public function findWithRelations(int $id): ForumTopic;
    
    public function create(array $data): ForumTopic;
    
    public function incrementViews(int $id): void;
}
