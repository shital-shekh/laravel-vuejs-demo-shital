<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class AuthController extends Controller
{
    public function register(Request $request) {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6'
        ]);

        if ($validator->fails()) {
            return ApiResponse::error(422, $validator->errors()->first());
        }

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return ApiResponse::success(201, 'User registered', $user);
    }

    public function login(Request $request) {

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
           return ApiResponse::error(422, $validator->errors()->first());
        }

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return ApiResponse::error(401, 'Invalid Credentials');
        }

        $token = $user->createToken('token')->plainTextToken;

        return ApiResponse::success(200, 'Login successful', [
            'token' => $token,
            'user'  => $user
        ]);
    }

    public function user(Request $request) {
        return ApiResponse::success(200, 'User', $request->user());
    }

    public function logout(Request $request) {
        $request->user()->tokens()->delete();
        return ApiResponse::success(200, 'Logged out');
    }
}
