<?php

namespace App\Http\Resources\Course\Exam;

use App\Http\Resources\FileResource;
use App\Http\Resources\Group\GroupResource;
use App\Http\Resources\User\UserResource;
use App\Models\ExamAssignment;
use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ExamAssigmentResource extends JsonResource
{
    /** @var ExamAssignment */
    public $resource;

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'attempts_allowed' => $this->resource->attempts_allowed,
            'is_control' => $this->resource->is_control,
            'start_at' => $this->resource->start_at,
            'end_at' => $this->resource->end_at,
            'group_id' => $this->resource->group_id,
            'exam' => ExamResource::make($this->whenLoaded('exam')),
            'instances' => ExamInstanceResource::collection($this->whenLoaded('instances')),
            'result' => ExamResultStatusResource::make($this->whenLoaded('resultStatus')),
            'group' => GroupResource::make($this->whenLoaded('group')),
            'user' => UserResource::make($this->whenLoaded('user')),
            'created_at' => $this->resource->created_at,
            'updated_at' => $this->resource->updated_at,
        ];
    }
}
