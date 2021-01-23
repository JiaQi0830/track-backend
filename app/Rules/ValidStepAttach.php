<?php

namespace App\Rules;

use App\Models\Step;
use Illuminate\Contracts\Validation\Rule;

class ValidStepAttach implements Rule
{
    private $errorMessageKey = 'Step does not exists';

    public function passes($attribute, $value)
    {
        return Step::find($value);
    }

    public function message()
    {
        return __($this->errorMessageKey);
    }
}
