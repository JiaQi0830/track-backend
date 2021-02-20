<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Enums\ProcessType;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Rules\ValidProcessAttach;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Rules\ValidProcessSequenceAttach;
use Illuminate\Support\Facades\Validator;
use Laravel\Lumen\Routing\Controller as BaseController;

class JobController extends BaseController
{
    public function getJob()
    {
        $step = Job::with(['created_by:id,username'])->get();

        return response(['data' => $step, 'message' => 'Retrieve successfully!', 'status' => true]);
    }

    public function getJobProcess(int $jobId)
    {
        $step = Job::where('id', $jobId)->with(['created_by:id,username'])
            ->with('jobProcesses.user:id,username')->with('jobProcesses.process')->get();

        return response(['data' => $step, 'message' => 'Retrieve successfully!', 'status' => true]);
    }

    public function storeJob(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'unique:jobs', 'string', 'max:125', 'bail'],
            'processes' => ['required', 'array', new ValidProcessSequenceAttach],
            'processes.*' => ['required', 'array', new ValidProcessAttach, 'bail'],
            'processes.*.id' => ['required', 'integer', 'bail'],
            'processes.*.type' => ['required', 'integer', Rule::in(ProcessType::getValues()), 'bail'],
            'processes.*.name' => ['nullable', 'string', 'bail'],
            'processes.*.expected_date' => ['nullable', 'date', 'bail'],
            'processes.*.sequence' => ['required', 'integer', 'bail']
        ]);

        if($validator->fails()){
            return response(['message' => 'Validation errors', 'errors' =>  $validator->errors(), 'status' => false], 422);
        }

        $inputData = array_merge($request->all(), ['created_by'=> Auth::id()]);
        DB::transaction(function () use ($inputData) {
            $job = Job::create(Arr::except($inputData, 'processes'));
            $processes = collect($inputData['processes'])->keyBy('id')->map(function ($process) {
                return Arr::except($process, ['id', 'name', 'type']);
            });

            $job->processes()->sync($processes, true);
        });
        return response(['data' => [], 'message' => 'Create successfully!', 'status' => true]);
    }

    public function editJob(Request $request, int $jobId)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', "unique:jobs,id, {$jobId}", 'string', 'max:125', 'bail'],
            'processes' => ['required', 'array', new ValidProcessSequenceAttach],
            'processes.*' => ['required', 'array', new ValidProcessAttach, 'bail'],
            'processes.*.id' => ['required', 'integer', 'bail'],
            'processes.*.expected_date' => ['nullable', 'date', 'bail']
        ]);

        if($validator->fails()){
            return response(['message' => 'Validation errors', 'errors' =>  $validator->errors(), 'status' => false], 422);
        }

        $inputData = array_merge($request->all(), ['created_by'=> Auth::id()]);
        DB::transaction(function () use ($inputData, $jobId) {
            $job = Job::findOrFail($jobId);
            $processes = collect($inputData['processes'])->keyBy('id')->map(function ($process) {
                return Arr::except($process, ['id', 'type']);
            });

            $job->processes()->sync($processes, true);
            $job->touch();
        });
        return response(['data' => [], 'message' => 'Edit successfully!', 'status' => true]);
    }

    public function completeProcess(Request $request, int $jobId, int $processId)
    {
        $validator = Validator::make($request->all(), [
            'completed_date' => ['required', 'date', 'bail']
        ]);

        if($validator->fails()){
            return response(['message' => 'Validation errors', 'errors' =>  $validator->errors(), 'status' => false], 422);
        }

        Job::findOrFail($jobId)->processes()->updateExistingPivot($processId, ['completed_date' => $request->completed_date, 'completed_by' => Auth::id()]);
        return response(['data' => [], 'message' => 'Update successfully!', 'status' => true]);
    }

    public function remarkProcess(Request $request, int $jobId, int $processId)
    {
        $validator = Validator::make($request->all(), [
            'remark' => ['required', 'string', 'bail']
        ]);

        if($validator->fails()){
            return response(['message' => 'Validation errors', 'errors' =>  $validator->errors(), 'status' => false], 422);
        }

        Job::findOrFail($jobId)->processes()->updateExistingPivot($processId, ['remark' => $request->remark]);
        return response(['data' => [], 'message' => 'Update successfully!', 'status' => true]);
    }

    public function fileProcess(Request $request, int $jobId, int $processId)
    {
        $validator = Validator::make($request->all(), [
            'doc' => ['required','bail', 'mimes:jpeg,bmp,png,gif,svg,pdf'],
        ]);

        if($validator->fails()){
            return response(['message' => 'Validation errors', 'errors' =>  $validator->errors(), 'status' => false], 422);
        }

        try{
            $request->file('doc')->move(base_path()."/public/files/{$jobId}/{$processId}", 'digimon');
        } catch (\Exception $ex) {
            return response(['data' => [], 'message' => $ex->getMessage(), 'status' => false]);
        }

        return response(['data' => [], 'message' => 'Upload successfully!', 'status' => true]);
    }
}
