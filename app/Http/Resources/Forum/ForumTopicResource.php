<?php

namespace App\Http\Resources\Forum;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ForumTopicResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'title' => $this->resource->title,
            'content' => $this->resource->content,
            'user' => [
                'id' => $this->resource->user->id,
                'name' => $this->resource->user->name,
                'rank' => 'Admin', // Placeholder for now
            ],
            'category' => ForumCategoryResource::make($this->whenLoaded('category')),
            'is_resolved' => $this->resource->is_resolved,
            'is_pinned' => $this->resource->is_pinned,
            'tags' => $this->resource->tags,
            'views_count' => $this->resource->views_count,
            'last_activity_at' => $this->resource->last_activity_at,
            'created_at' => $this->resource->created_at,
            'posts_count' => $this->resource->posts_count,
            'is_liked' => $this->resource->is_liked ?? false,
            'likes_count' => $this->resource->likes_count ?? 0,
        ];
    }
}
