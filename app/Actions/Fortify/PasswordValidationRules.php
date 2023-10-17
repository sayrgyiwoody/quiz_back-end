<?php

namespace App\Actions\Fortify;

use Laravel\Fortify\Rules\Password;
use App\Rules\passwordRequirements;

trait PasswordValidationRules
{
    /**
     * Get the validation rules used to validate passwords.
     *
     * @return array<int, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    protected function passwordRules(): array
    {
        return ['required', 'string', new Password, 'confirmed','min:8',new passwordRequirements];
    }
}
