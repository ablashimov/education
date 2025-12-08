<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Interfaces\Repositories\ForumPostRepositoryInterface;
use App\Models\ForumPost;
use App\Models\ForumTopic;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

readonly class ForumPostRepository extends AbstractRepository implements ForumPostRepositoryInterface
{
    public function getModel(): Model
    {
        return new ForumPost;
    }

    public function getByTopic(int $topicId): Collection
    {
        return $this->getQuery()
            ->with(['user', 'likes'])
            ->where('forum_topic_id', $topicId)
            ->orderBy('created_at', 'asc')
            ->get();
    }

    public function create(array $data): ForumPost
    {
        return $this->getModel()->create($data);
    }

    public function markAsSolution(int $topicId, int $postId): void
    {
        DB::transaction(function () use ($topicId, $postId) {
            ForumPost::where('forum_topic_id', $topicId)
                ->update(['is_solution' => false]);

            ForumPost::where('id', $postId)
                ->where('forum_topic_id', $topicId)
                ->update(['is_solution' => true]);

            ForumTopic::where('id', $topicId)
                ->update(['is_resolved' => true]);
        });
    }
}
