<?php

namespace App\Http\Controllers\Api\V1\Forum;

use App\Actions\Forum\CreateForumTopic;
use App\Actions\Forum\GetForumCategories;
use App\Actions\Forum\GetForumTopic;
use App\Actions\Forum\GetForumTopics;
use App\Actions\Forum\MarkPostAsSolution;
use App\Actions\Forum\ReplyToForumTopic;
use App\Actions\Forum\ToggleForumLike;
use App\Http\Controllers\Controller;
use App\Http\Requests\Forum\CreateTopicRequest;
use App\Http\Requests\Forum\GetTopicsRequest;
use App\Http\Requests\Forum\LikeRequest;
use App\Http\Requests\Forum\ReplyToTopicRequest;
use App\Http\Resources\Forum\ForumCategoryResource;
use App\Http\Resources\Forum\ForumPostResource;
use App\Http\Resources\Forum\ForumTopicCollection;
use App\Http\Resources\Forum\ForumTopicResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;

class ForumController extends Controller
{
    public function categories(GetForumCategories $action): AnonymousResourceCollection
    {
        $categories = $action->execute();
        return ForumCategoryResource::collection($categories);
    }

    public function index(GetTopicsRequest $request, GetForumTopics $action): ForumTopicCollection
    {
        $topics = $action->execute($request->validated());
        return new ForumTopicCollection($topics);
    }

    public function store(CreateTopicRequest $request, CreateForumTopic $action): ForumTopicResource
    {
        $topic = $action->execute($request->validated());
        return new ForumTopicResource($topic);
    }

    public function show(int $id, GetForumTopic $action): JsonResponse
    {
        $result = $action->execute($id);
        
        return response()->json([
            'topic' => new ForumTopicResource($result['topic']),
            'posts' => ForumPostResource::collection($result['posts']),
        ]);
    }

    public function reply(ReplyToTopicRequest $request, int $id, ReplyToForumTopic $action): ForumPostResource
    {
        $post = $action->execute($id, $request->input('content'));
        return new ForumPostResource($post);
    }

    public function like(LikeRequest $request, ToggleForumLike $action): JsonResponse
    {
        $result = $action->execute(
            Auth::id(),
            $request->input('id'),
            $request->input('type')
        );

        return response()->json($result);
    }

    public function resolve(int $topicId, int $postId, MarkPostAsSolution $action): JsonResponse
    {
        $action->execute($topicId, $postId);
        return response()->json(['success' => true]);
    }
}
