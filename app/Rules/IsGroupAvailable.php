<?php

namespace App\Rules;

use App\Repositories\GroupRepository;
use App\Traits\Rules\DataAwareRuleTrait;
use Closure;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\ValidationRule;

class IsGroupAvailable implements ValidationRule, DataAwareRule
{
    use DataAwareRuleTrait;

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (empty($this->data['user_id'])) {
            return;
        }

        $group = app()->make(GroupRepository::class)->isInvitePossible($value, $this->data['user_id']);

        if ($group) {
            return;
        }

        $fail('Не можливо додати користувача до цієї групи.');
    }
}
