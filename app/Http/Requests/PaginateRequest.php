<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaginateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'page' => 'integer|min:1',
            'per_page' => 'integer|min:1|max:110',
        ];
    }

    protected function prepareForValidation()
    {
        $user = auth()->user();
        $this->merge([
            'user_id' => $user->id,
            'organization_id' => $user->organization_id,
        ]);
    }
}
