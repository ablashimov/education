<?php

namespace App\Actions\Forum;

use App\Interfaces\Repositories\ForumLikeRepositoryInterface;
use App\Models\ForumPost;
use App\Models\ForumTopic;

readonly class ToggleForumLike
{
    public function __construct(
        private ForumLikeRepositoryInterface $repository
    ) {}

    public function execute(int $userId, int $id, string $type): array
    {
        $modelClass = $type === 'topic' ? ForumTopic::class : ForumPost::class;

        if ($type === 'topic') {
            ForumTopic::findOrFail($id);
        } else {
            ForumPost::findOrFail($id);
        }

        $liked = $this->repository->toggle($userId, $id, $modelClass);
        $count = $this->repository->count($id, $modelClass);

        return [
            'liked' => $liked,
            'likes_count' => $count,
        ];
    }
}
