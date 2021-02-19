<?php

namespace App\Rules;

use App\Models\Process;
use App\Enums\ProcessType;
use Illuminate\Contracts\Validation\Rule;

class ValidProcessAttach implements Rule
{
    private $errorMessageKey = 'Step does not exists';
    private $errorMessageNameKey = 'No name assign for new process create.';

    public function passes($attribute, $value)
    {
        $this->value = $value;

        if($value['type'] == ProcessType::ProcessSpecific){
            return isset($value['name']) && $value['name'] != '';
        }else{
            return Process::find($value);
        }
    }

    public function message()
    {
        if($this->value['type'] == ProcessType::ProcessSpecific){
            return __($this->errorMessageNameKey);
        }else{
            return __($this->errorMessageKey);
        }
    }
}
