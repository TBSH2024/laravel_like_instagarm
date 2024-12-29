<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\Rule;

class NoForbiddenWords implements Rule
{
    protected $forbiddenWords = ['ヴォルデモート', 'ぎっちょ'];
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        //
    }

    public function passes($attribute, $value)
    {
        foreach ($this->forbiddenWords as $word) {
            if (mb_strpos($value, $word) !== false) {
                return false;
            }
        }
        return true;
    }

    public function message(): string
    {
        return '禁止ワードが含まれています';
    }
}
