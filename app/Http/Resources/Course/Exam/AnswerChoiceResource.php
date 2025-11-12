<?php

namespace App\Http\Resources\Course\Exam;

use App\Models\AnswerChoice;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AnswerChoiceResource extends JsonResource
{
    /** @var AnswerChoice */
    public $resource;

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'question_choice_id' => $this->resource->question_choice_id,
        ];
    }
}
