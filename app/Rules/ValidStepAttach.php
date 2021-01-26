<?php

namespace App\Rules;

use App\Enums\StepType;
use App\Models\Step;
use Illuminate\Contracts\Validation\Rule;

class ValidStepAttach implements Rule
{
    private $errorMessageKey = 'Step does not exists';
    private $errorMessageNameKey = 'No name assign for new process create.';

    public function passes($attribute, $value)
    {
        $this->value = $value;

        if($value['type'] == StepType::ProcessSpecific){
            return isset($value['name']) && $value['name'] != '';
        }else{
            return Step::find($value);
        }
    }

    public function message()
    {
        if($this->value['type'] == StepType::ProcessSpecific){
            return __($this->errorMessageNameKey);
        }else{
            return __($this->errorMessageKey);
        }
    }
}
