<?php

declare(strict_types=1);

namespace App\Interfaces\Repositories;

interface ForumLikeRepositoryInterface extends RepositoryInterface
{
    public function toggle(int $userId, int $likeableId, string $likeableType): bool;
    
    public function isLiked(int $userId, int $likeableId, string $likeableType): bool;
    
    public function count(int $likeableId, string $likeableType): int;
}
