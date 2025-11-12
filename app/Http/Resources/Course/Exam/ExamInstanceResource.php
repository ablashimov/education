<?php

namespace App\Http\Resources\Course\Exam;

use App\Models\ExamInstance;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ExamInstanceResource extends JsonResource
{
    /** @var ExamInstance */
    public $resource;

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'assignment_id' => $this->resource->assignment_id,
            'user_id' => $this->resource->user_id,
            'attempt_number' => $this->resource->attempt_number,
            'start_at' => $this->resource->start_at,
            'end_at' => $this->resource->end_at,
            'questions' => QuestionResource::collection($this->whenLoaded('questions')),
            'assignment' => ExamAssigmentResource::make($this->whenLoaded('assignment')),
            'attempt' => AttemptResource::make($this->whenLoaded('attempt')),
            'created_at' => $this->resource->created_at,
            'updated_at' => $this->resource->updated_at,
        ];
    }
}
