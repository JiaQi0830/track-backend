<?php

namespace App\Http\Controllers;

use App\Models\Step;
use Illuminate\Http\Request;
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
            'username' => 'required|exists:users',
            'password' => 'required'
        ]);

        if($validator->fails()){
            return response(['message' => 'Validation errors', 'errors' =>  $validator->errors(), 'status' => false], 422);
        }

        return response(['data' => $step, 'message' => 'Retrieve successfully!', 'status' => true]);
    }

}
