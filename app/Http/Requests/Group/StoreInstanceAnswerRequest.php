<?php

namespace App\Http\Requests\Group;

use Illuminate\Foundation\Http\FormRequest;

class StoreInstanceAnswerRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'answers' => 'required|array',
            'answers.*.question_id' => 'required|integer',
            'answers.*.choice_ids' => 'required_without:answers.*.text|array',
            'answers.*.choice_ids.*' => 'required|integer',
            'answers.*.text' => 'required_without:answers.*.choice_ids|string|max:50000',
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'exam_instance_id' => $this->route('examInstanceId'),
            'attempt_id' => $this->route('attemptId'),
            'user_id' => auth()->user()->id,
        ]);
    }
}
