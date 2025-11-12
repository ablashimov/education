<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class StoreTokenRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'string|required|max:255',
            'expires_at' => 'date|nullable|after:today',
        ];
    }
}
