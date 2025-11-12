<?php

namespace App\Http\Requests\Group;

use App\Rules\IsGroupAvailable;
use Illuminate\Foundation\Http\FormRequest;

class InviteRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'group_id' => ['required', new IsGroupAvailable],
            'user_id' => 'required|exists:users,id,organization_id,' . auth()->user()->organization_id,
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'group_id' => $this->route('groupId'),
        ]);
    }
}
