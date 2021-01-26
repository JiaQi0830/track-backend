<?php

namespace App\Http\Controllers;

use App\Models\Step;
use App\Enums\StepType;
use App\Models\Process;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Rules\ValidStepAttach;
use Illuminate\Validation\Rule;
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

    public function getProcess()
    {
        $step = Process::all();

        return response(['data' => $step, 'message' => 'Retrieve successfully!', 'status' => true]);
    }

    public function getProcessStep(int $processId)
    {
        $step = Process::where('id', $processId)->with('processSteps.user')->with('processSteps.step')->get();

        return response(['data' => $step, 'message' => 'Retrieve successfully!', 'status' => true]);
    }

    public function storeProcess(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'unique:processes', 'string', 'max:125', 'bail'],
            'steps' => ['required', 'array', new ValidStepSequenceAttach],
            'steps.*' => ['required', 'array', new ValidStepAttach, 'bail'],
            'steps.*.id' => ['required', 'integer', 'bail'],
            'steps.*.type' => ['required', 'integer', Rule::in(StepType::getValues()), 'bail'],
            'steps.*.name' => ['nullable', 'string', 'bail'],
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
                return Arr::except($step, ['id', 'name', 'type']);
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

    public function completeProcess(Request $request, int $processId, int $stepId)
    {
        $validator = Validator::make($request->all(), [
            'completed_date' => ['required', 'date', 'bail']
        ]);

        if($validator->fails()){
            return response(['message' => 'Validation errors', 'errors' =>  $validator->errors(), 'status' => false], 422);
        }

        Process::findOrFail($processId)->steps()->updateExistingPivot($stepId, ['completed_date' => $request->completed_date, 'completed_by' => Auth::id()]);
        return response(['data' => [], 'message' => 'Update successfully!', 'status' => true]);
    }

}
