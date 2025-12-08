<?php

namespace App\Http\Resources\Forum;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ForumPostResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'content' => $this->resource->content,
            'user' => $this->resource->user ? [
                'id' => $this->resource->user->id,
                'name' => $this->resource->user->name,
                'rank' => 'Admin', // Placeholder for now
            ] : null,
            'is_solution' => $this->resource->is_solution,
            'created_at' => $this->resource->created_at,
            'is_liked' => $this->resource->is_liked ?? false,
            'likes_count' => $this->resource->likes_count ?? 0,
        ];
    }
}
