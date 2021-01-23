<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Lumen\Routing\Controller as BaseController;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class Controller extends BaseController
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed'
        ]);

        if($validator->fails()){
            return response(['message' => 'Validation errors', 'errors' =>  $validator->errors(), 'status' => false], 422);
        }

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);

        $user = User::create($input);

        $data['token'] =  $user->createToken('MyApp')->accessToken;
        $data['username'] =  $user->name;

        return response(['data' => $data, 'message' => 'Account created successfully!', 'status' => true]);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|exists:users',
            'password' => 'required'
        ]);

        if($validator->fails()){
            return response(['message' => 'Validation errors', 'errors' =>  $validator->errors(), 'status' => false], 422);
        }

        $user = User::where('username', $request->username)->firstOrFail();

        if (!Hash::check($request->password, $user->getAuthPassword())) {
            throw new BadRequestException('Wrong password or email');
        }

        $data['token'] =  $user->createToken('MyApp')->accessToken;
        $data['username'] =  $user->name;

        return response(['data' => $data, 'message' => 'Login successfully!', 'status' => true]);
    }
}
