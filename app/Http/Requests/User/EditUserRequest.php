<?php

namespace App\Http\Requests\User;

use Illuminate\Validation\Rule;

class EditUserRequest extends StoreUserRequest
{
    public function rules(): array
    {
        $rules = parent::rules();
        $rules['email'] = [
            'required',
            'email',
            Rule::unique('users', 'email')->ignoreModel($this->route('user')),
        ];
        $rules['password'] = 'string|max:255|min:6|nullable';

        return $rules;
    }
}
