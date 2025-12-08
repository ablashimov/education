<?php

declare(strict_types=1);

namespace App\Interfaces\Repositories;

use App\Models\ForumPost;
use Illuminate\Database\Eloquent\Collection;

interface ForumPostRepositoryInterface extends RepositoryInterface
{
    public function getByTopic(int $topicId): Collection;
    
    public function create(array $data): ForumPost;
    
    public function markAsSolution(int $topicId, int $postId): void;
}
