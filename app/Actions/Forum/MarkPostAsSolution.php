<?php

namespace App\Actions\Forum;

use App\Interfaces\Repositories\ForumPostRepositoryInterface;
use App\Interfaces\Repositories\ForumTopicRepositoryInterface;
use Illuminate\Support\Facades\Auth;

readonly class MarkPostAsSolution
{
    public function __construct(
        private ForumTopicRepositoryInterface $topicRepository,
        private ForumPostRepositoryInterface $postRepository
    ) {}

    public function execute(int $topicId, int $postId): void
    {
        $this->topicRepository->findBy([
            'id' => $topicId,
            'user_id' => Auth::id()
        ]);

        $this->postRepository->findBy([
            'id' => $postId,
            'forum_topic_id' => $topicId
        ]);

        $this->postRepository->markAsSolution($topicId, $postId);
    }
}
