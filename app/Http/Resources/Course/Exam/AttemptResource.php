<?php

namespace App\Http\Resources\Course\Exam;

use App\Http\Resources\User\UserResource;
use App\Models\ExamAttempt;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AttemptResource extends JsonResource
{
    /** @var ExamAttempt */
    public $resource;

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'exam_instance_id' => $this->resource->exam_instance_id,
            'started_at' => $this->resource->started_at,
            'submitted_at' => $this->resource->submitted_at,
            'elapsed_seconds' => $this->resource->elapsed_seconds,
            'score' => $this->resource->score,
            'graded_by' => UserResource::make($this->whenLoaded('gradedBy')),
            'answers' => AnswerResource::collection($this->whenLoaded('answers')),
            'created_at' => $this->resource->created_at,
            'updated_at' => $this->resource->updated_at,
        ];
    }
}
