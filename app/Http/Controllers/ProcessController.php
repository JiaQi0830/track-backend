<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Lumen\Routing\Controller as BaseController;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class ProcessController extends BaseController
{
    public function getStep()
    {

        $data['token'] =  $user->createToken('MyApp')->accessToken;
        $data['username'] =  $user->name;

        return response(['data' => $data, 'message' => 'Retrieve successfully!', 'status' => true]);
    }

}
