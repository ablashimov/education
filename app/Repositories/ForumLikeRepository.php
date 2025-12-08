<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Interfaces\Repositories\ForumLikeRepositoryInterface;
use App\Models\ForumLike;
use Illuminate\Database\Eloquent\Model;

readonly class ForumLikeRepository extends AbstractRepository implements ForumLikeRepositoryInterface
{
    public function getModel(): Model
    {
        return new ForumLike;
    }

    public function toggle(int $userId, int $likeableId, string $likeableType): bool
    {
        $existingLike = $this->getQuery()
            ->where('user_id', $userId)
            ->where('likeable_id', $likeableId)
            ->where('likeable_type', $likeableType)
            ->first();

        if ($existingLike) {
            $existingLike->delete();
            return false; // unliked
        }

        $this->getModel()->create([
            'user_id' => $userId,
            'likeable_id' => $likeableId,
            'likeable_type' => $likeableType,
        ]);

        return true; // liked
    }

    public function isLiked(int $userId, int $likeableId, string $likeableType): bool
    {
        return $this->getQuery()
            ->where('user_id', $userId)
            ->where('likeable_id', $likeableId)
            ->where('likeable_type', $likeableType)
            ->exists();
    }

    public function count(int $likeableId, string $likeableType): int
    {
        return $this->getQuery()
            ->where('likeable_id', $likeableId)
            ->where('likeable_type', $likeableType)
            ->count();
    }
}
