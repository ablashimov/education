<?php

namespace App\Http\Resources\Course\Exam;

use App\Http\Resources\FileResource;
use App\Models\Exam;
use App\Models\ExamAssignment;
use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ExamResource extends JsonResource
{
    /** @var Exam */
    public $resource;

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'title' => $this->resource->title,
            'description' => $this->resource->description,
            'attempts_allowed' => $this->resource->attempts_allowed,
            'time_limit' => $this->resource->time_limit,
            'config' => $this->resource->config,
            'created_at' => $this->resource->created_at,
            'updated_at' => $this->resource->updated_at,
        ];
    }
}
