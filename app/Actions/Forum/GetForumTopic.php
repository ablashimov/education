<?php

namespace App\Actions\Forum;

use App\Interfaces\Repositories\ForumPostRepositoryInterface;
use App\Interfaces\Repositories\ForumTopicRepositoryInterface;
use Illuminate\Support\Facades\Auth;

readonly class GetForumTopic
{
    public function __construct(
        private ForumTopicRepositoryInterface $topicRepository,
        private ForumPostRepositoryInterface $postRepository
    ) {}

    public function execute(int $id): array
    {
        $topic = $this->topicRepository->findWithRelations($id);
        $userId = Auth::id();

        $sessionKey = "forum_topic_viewed_{$id}";
        if (!session()->has($sessionKey)) {
            $this->topicRepository->incrementViews($id);
            session()->put($sessionKey, true);
        }

        $topic->is_liked = $topic->likes->where('user_id', $userId)->isNotEmpty();
        $topic->likes_count = $topic->likes->count();
        unset($topic->likes);

        $posts = $this->postRepository->getByTopic($id)
            ->map(function ($post) use ($userId) {
                $post->is_liked = $post->likes->where('user_id', $userId)->isNotEmpty();
                $post->likes_count = $post->likes->count();
                unset($post->likes);
                return $post;
            });

        return [
            'topic' => $topic,
            'posts' => $posts,
        ];
    }
}
