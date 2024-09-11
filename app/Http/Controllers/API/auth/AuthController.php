<?php

namespace App\Http\Controllers\API\auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Requests\Api\RegisterRequest;
use App\Http\Resources\ApiResponse;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $token = $user->createToken('auth_token')->plainTextToken;
        return (new ApiResponse((object)[
            'status' => 'success',
            'data' => ['user' => $user, 'token' => $token],
            'message' => 'User registered successfully.',
        ]))->response()->setStatusCode(201);
    }

    public function login(LoginRequest $request)
    {

        if (!Auth::attempt($request->only('email', 'password'))) {
            return (new ApiResponse((object)[
                'status' => 'fail',
                'error' => 'Invalid credentials.',
                'message' => 'Login failed.',
            ]))->response()->setStatusCode(401);
        }
        $user = Auth::user();
        $token = $user->createToken('auth_token')->plainTextToken;
        return (new ApiResponse((object)[
            'status' => 'success',
            'data' => ['user' => $user, 'token' => $token],
            'message' => 'User logged in successfully.',
        ]))->response()->setStatusCode(200);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return (new ApiResponse((object)[
            'status' => 'success',
            'message' => 'User logged out successfully.',
        ]))->response()->setStatusCode(200);
    }
}
