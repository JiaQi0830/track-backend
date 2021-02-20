<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Laravel\Lumen\Routing\Controller as BaseController;

class JobProcessController extends BaseController
{
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
            $file = $request->file('doc');
            $file->move(base_path()."/public/files/{$jobId}/{$processId}", $file->getClientOriginalName());
        } catch (\Exception $ex) {
            return response(['data' => [], 'message' => $ex->getMessage(), 'status' => false]);
        }

        return response(['data' => [], 'message' => 'Upload successfully!', 'status' => true]);
    }
}
