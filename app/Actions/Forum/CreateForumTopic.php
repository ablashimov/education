<?php

namespace App\Actions\Forum;

use App\Interfaces\Repositories\ForumCategoryRepositoryInterface;
use App\Interfaces\Repositories\ForumTopicRepositoryInterface;
use App\Models\ForumTopic;
use Illuminate\Support\Facades\Auth;

readonly class CreateForumTopic
{
    public function __construct(
        private ForumTopicRepositoryInterface $topicRepository,
        private ForumCategoryRepositoryInterface $categoryRepository
    ) {}

    public function execute(array $data): ForumTopic
    {
        $category = $this->categoryRepository->findBy(['name' => $data['category']]);

        return $this->topicRepository->create([
            'title' => $data['title'],
            'content' => $data['content'],
            'user_id' => Auth::id(),
            'forum_category_id' => $category->id,
            'tags' => $data['tags'] ?? [],
        ]);
    }
}
