<?php

namespace App\Http\Requests\Forum;

use Illuminate\Foundation\Http\FormRequest;

class GetTopicsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'page' => 'integer|min:1',
            'category' => 'string|nullable',
            'search' => 'string|nullable',
            'status' => 'string|in:resolved,unresolved|nullable',
            'sort_by' => 'string|in:recent,popular,unanswered|nullable',
        ];
    }
}
