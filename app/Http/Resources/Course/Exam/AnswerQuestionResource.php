<?php

namespace App\Http\Resources\Course\Exam;

use App\Models\ExamInstanceQuestion;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AnswerQuestionResource extends JsonResource
{
    /** @var Question */
    public $resource;

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'text' => $this->resource->text,
            'score' => $this->resource->score,
            'question_type' => QuestionTypeResource::make($this->whenLoaded('type')),
            'choices' => AnswerQuestionChoiceResource::collection($this->whenLoaded('choices')),
            'metadata' => $this->resource->metadata,
            'created_at' => $this->resource->created_at,
            'updated_at' => $this->resource->updated_at,
        ];
    }
}
