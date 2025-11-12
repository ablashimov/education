<?php

namespace App\Http\Resources\Course\Exam;

use App\Models\QuestionChoice;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AnswerQuestionChoiceResource extends JsonResource
{
    /** @var QuestionChoice */
    public $resource;

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'text' => $this->resource->text,
            'scoring' => $this->resource->scoring,
            'correct' => $this->resource->correct,
            'order' => $this->resource->order,
            'created_at' => $this->resource->created_at,
            'updated_at' => $this->resource->updated_at,
        ];
    }
}
