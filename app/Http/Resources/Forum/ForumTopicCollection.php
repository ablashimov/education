<?php

namespace App\Http\Resources\Forum;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ForumTopicCollection extends ResourceCollection
{
    public function toArray(Request $request): array
    {
        return [
            'data' => ForumTopicResource::collection($this->collection),
            'current_page' => $this->resource->currentPage(),
            'last_page' => $this->resource->lastPage(),
            'total' => $this->resource->total(),
        ];
    }
}
