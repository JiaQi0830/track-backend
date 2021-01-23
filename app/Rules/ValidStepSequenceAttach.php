<?php

namespace App\Rules;

use App\Models\Step;
use Illuminate\Contracts\Validation\Rule;

class ValidStepSequenceAttach implements Rule
{
    private $errorMessageKey = 'Step sequence duplicate';

    public function passes($attribute, $value)
    {
        return (collect($value)->count() == collect($value)->unique('sequence')->count());
    }

    public function message()
    {
        return __($this->errorMessageKey);
    }
}
