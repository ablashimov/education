<?php

namespace App\Actions\Forum;

use App\Interfaces\Repositories\ForumPostRepositoryInterface;
use App\Interfaces\Repositories\ForumTopicRepositoryInterface;
use App\Models\ForumPost;
use Illuminate\Support\Facades\Auth;

readonly class ReplyToForumTopic
{
    public function __construct(
        private ForumPostRepositoryInterface $postRepository,
        private ForumTopicRepositoryInterface $topicRepository
    ) {}

    public function execute(int $topicId, string $content): ForumPost
    {
        $topic = $this->topicRepository->getById($topicId);

        $post = $this->postRepository->create([
            'content' => $content,
            'user_id' => Auth::id(),
            'forum_topic_id' => $topic->id,
        ]);

        $this->topicRepository->updateModel($topic, ['last_activity_at' => now()]);

        $post->load('user');
        $post->is_liked = false;
        $post->likes_count = 0;

        return $post;
    }
}
