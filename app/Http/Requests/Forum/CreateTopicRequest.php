<?php

namespace App\Http\Requests\Forum;

use Illuminate\Foundation\Http\FormRequest;

class CreateTopicRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|min:10',
            'content' => 'required|string|min:20',
            'category' => 'required|string|exists:forum_categories,name',
            'tags' => 'array|max:5',
            'tags.*' => 'string',
        ];
    }
}
