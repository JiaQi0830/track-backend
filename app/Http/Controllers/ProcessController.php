<?php

namespace App\Http\Controllers;

use App\Models\Process;
use App\Enums\ProcessType;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Laravel\Lumen\Routing\Controller as BaseController;

class ProcessController extends BaseController
{
    public function getProcess()
    {
        $process = Process::where('type', ProcessType::General)->get();

        return response(['data' => $process, 'message' => 'Retrieve successfully!', 'status' => true]);
    }

    public function storeProcess(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'unique:steps', 'string', 'max:125', 'bail'],
            'type' => ['required', 'bail', Rule::in(ProcessType::getValues())]
        ]);

        Process::create($request->all());

        if($validator->fails()){
            return response(['message' => 'Validation errors', 'errors' =>  $validator->errors(), 'status' => false], 422);
        }

        return response(['data' => [], 'message' => 'Create successfully!', 'status' => true]);
    }

}
