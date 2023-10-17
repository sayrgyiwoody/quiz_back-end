<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
class passwordRequirements implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $requirements = 0;
        $lowercase = preg_match('/[a-z]/', $value);
        $uppercase = preg_match('/[A-Z]/', $value);
        $number = preg_match('/[0-9]/', $value);
        $specialChar = preg_match('/[^A-Za-z0-9]/', $value);

        if ($lowercase) {
            $requirements++;
        }

        if ($uppercase) {
            $requirements++;
        }

        if ($number) {
            $requirements++;
        }

        if ($specialChar) {
            $requirements++;
        }

        if ($requirements < 3) {
            $fail('Please obey the password rules.');
        }
    }
}
