<?php

namespace App\Http\Controllers;

use App\Models\Step;
use App\Enums\StepType;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Laravel\Lumen\Routing\Controller as BaseController;

class StepController extends BaseController
{
    public function getStep()
    {
        $step = Step::where('type', StepType::General)->get();

        return response(['data' => $step, 'message' => 'Retrieve successfully!', 'status' => true]);
    }

    public function storeStep(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'unique:steps', 'string', 'max:125', 'bail'],
            'type' => ['required', 'bail', Rule::in(StepType::getValues())]
        ]);

        Step::create($request->all());

        if($validator->fails()){
            return response(['message' => 'Validation errors', 'errors' =>  $validator->errors(), 'status' => false], 422);
        }

        return response(['data' => [], 'message' => 'Create successfully!', 'status' => true]);
    }

}
