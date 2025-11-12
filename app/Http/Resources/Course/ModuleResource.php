<?php

namespace App\Http\Resources\Course;

use App\Http\Resources\Course\Lesson\LessonResource;
use App\Http\Resources\FileResource;
use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ModuleResource extends JsonResource
{
    /** @var Module */
    public $resource;

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'title' => $this->resource->title,
            'order' => $this->resource->order,
            'settings' => $this->resource->settings,
            'lessons' => LessonResource::collection($this->whenLoaded('lessons')),
            'created_at' => $this->resource->created_at,
            'updated_at' => $this->resource->updated_at,
        ];
    }
}
