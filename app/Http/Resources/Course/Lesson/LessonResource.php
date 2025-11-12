<?php

namespace App\Http\Resources\Course\Lesson;

use App\Http\Resources\FileResource;
use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LessonResource extends JsonResource
{
    /** @var Lesson */
    public $resource;

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'title' => $this->resource->title,
            'material' => $this->resource->material,
            'order' => $this->resource->order,
            'settings' => $this->resource->settings,
            'files' => FileResource::collection($this->whenLoaded('files')),
            'created_at' => $this->resource->created_at,
            'updated_at' => $this->resource->updated_at,
        ];
    }
}
