<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email'),
            ],
            'name' => 'string|required|max:255',
            'password' => 'string|max:255|min:6|required',
            'rank' => 'required|string',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'organization_id' => auth()->user()->organization_id,
        ]);
    }
}
