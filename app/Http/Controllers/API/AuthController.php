<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;


class AuthController extends BaseController
{
    public function userAuth()
    {
        $user = Auth::user();
        return $this->sendResponse($user, 'user authenticated');
    }

    public function signin(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->sendError('You must add all information', ['error' => $validator->errors()], 403);
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $authUser = Auth::user();
            $success['accessToken'] = $authUser->createToken('accessToken')->plainTextToken;
            $success['userAuth'] = $authUser;
            return $this->sendResponse($success, 'User signed up');
        } else {
            return $this->sendError('Unauthorized.', ['error' => 'Unauthorized.'], 401);
        }
    }

    public function signup(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'confirm_password' => 'required|same:password'
        ]);
        if ($validator->fails()) {
            return $this->sendError('Invalid Data.', $validator->errors(), 403);
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['accessToken'] = $user->createToken('accessToken')->plainTextToken;
        $success['userAuth'] = $user;
        return $this->sendResponse($success, 'User created successfully.');
    }

    public function logout()
    {
        $user = Auth::user();
        if (!$user) {
            return $this->sendError('User not found', ['error' => 'User not found']);
        }
        $user->tokens()->delete();
        return $user;
    }
}
