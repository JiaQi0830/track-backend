<?php

namespace App\Http\Controllers;

use App\Models\Step;
use App\Models\Process;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Rules\ValidStepAttach;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Rules\ValidStepSequenceAttach;
use Illuminate\Support\Facades\Validator;
use Laravel\Lumen\Routing\Controller as BaseController;

class ProcessController extends BaseController
{
    public function getStep()
    {
        $step = Step::all();

        return response(['data' => $step, 'message' => 'Retrieve successfully!', 'status' => true]);
    }

    public function storeProcess(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'unique:processes', 'string', 'max:125', 'bail'],
            'steps' => ['required', 'array', new ValidStepSequenceAttach],
            'steps.*.id' => ['required', 'integer', new ValidStepAttach, 'bail'],
            'steps.*.expected_date' => ['nullable', 'date', 'bail'],
            'steps.*.sequence' => ['required', 'integer', 'bail']
        ]);

        if($validator->fails()){
            return response(['message' => 'Validation errors', 'errors' =>  $validator->errors(), 'status' => false], 422);
        }

        $inputData = array_merge($request->all(), ['created_by'=> Auth::id()]);
        DB::transaction(function () use ($inputData) {
            $process = Process::create(Arr::except($inputData, 'steps'));
            $steps = collect($inputData['steps'])->keyBy('id')->map(function ($step) {
                return Arr::except($step, 'id');
            });

            $process->steps()->sync($steps, true);
        });
        return response(['data' => [], 'message' => 'Create successfully!', 'status' => true]);
    }

    public function editProcess(Request $request, int $processId)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', "unique:processes,id, {$processId}", 'string', 'max:125', 'bail'],
            'steps' => ['required', 'array', new ValidStepSequenceAttach],
            'steps.*.id' => ['required', 'integer', new ValidStepAttach, 'bail'],
            'steps.*.expected_date' => ['nullable', 'date', 'bail']
        ]);

        if($validator->fails()){
            return response(['message' => 'Validation errors', 'errors' =>  $validator->errors(), 'status' => false], 422);
        }

        $inputData = array_merge($request->all(), ['created_by'=> Auth::id()]);
        DB::transaction(function () use ($inputData, $processId) {
            $process = Process::findOrFail($processId);
            $steps = collect($inputData['steps'])->keyBy('id')->map(function ($step) {
                return Arr::except($step, 'id');
            });

            $process->steps()->sync($steps, true);
            $process->touch();
        });
        return response(['data' => [], 'message' => 'Edit successfully!', 'status' => true]);
    }

}
