<?php

namespace App\Actions\Forum;

use App\Interfaces\Repositories\ForumTopicRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

readonly class GetForumTopics
{
    public function __construct(
        private ForumTopicRepositoryInterface $repository
    ) {}

    public function execute(array $filters, int $perPage = 15): LengthAwarePaginator
    {
        $topics = $this->repository->paginate($filters, $perPage);
        $userId = Auth::id();

        $topics->getCollection()->transform(function ($topic) use ($userId) {
            $topic->is_liked = $topic->likes->where('user_id', $userId)->isNotEmpty();
            $topic->likes_count = $topic->likes->count();
            unset($topic->likes);
            return $topic;
        });

        return $topics;
    }
}
