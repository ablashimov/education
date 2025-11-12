<?php

namespace App\Http\Resources\Course\Exam;

use App\Models\ExamAnswer;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AnswerResource extends JsonResource
{
    /** @var ExamAnswer */
    public $resource;

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'exam_attempt_id' => $this->resource->exam_attempt_id,
            'question' => AnswerQuestionResource::make($this->whenLoaded('question')),
            'question_id' => $this->resource->question_id,
            'user_choices' => AnswerChoiceResource::collection($this->whenLoaded('choices')),
            'answer' => $this->resource->answer,
            'is_correct' => $this->resource->is_correct,
            'graded_by' => $this->resource->graded_by,
            'created_at' => $this->resource->created_at,
            'updated_at' => $this->resource->updated_at,
        ];
    }
}
