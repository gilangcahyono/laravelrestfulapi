<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $data = $request->validated();
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
        return response()->json([
            'ok' => true,
            'message' => 'User logged in successfully',
            'data' => $user,
            'errors' => null
        ]);
    }

    public function login(LoginRequest $request) // done
    {
        $data = $request->validated();
        try {
            $user = User::where('email', $data['email'])->first();

            if (!$user) {
                return response()->json([
                    'ok' => false,
                    'message' => 'Invalid credentials',
                    'data' => null,
                    'errors' => [
                        'email' => ['Email not found']
                    ]

                ], 401);
            }

            if (!Hash::check($request->password, $user->password)) {
                return response()->json([
                    'ok' => false,
                    'message' => 'Invalid credentials',
                    'data' => null,
                    'errors' => [
                        'password' => ['Incorrect password']
                    ]

                ], 401);
            }

            // if (true) throw new Error();

            $token =  $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'ok' => true,
                'message' => 'User logged in successfully',
                'data' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'token' => $token
                ],
                'errors' => null
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'ok' => false,
                'message' => 'Internal server error',
                'data' => null,
                'errors' => $th->getMessage()
            ], 500);
        }
    }

    public function user(Request $request)
    {
        $user = [
            'id' => $request->user()->id,
            'name' => $request->user()->name,
            'email' => $request->user()->email
        ];
        return response()->json([
            'ok' => true,
            'message' => 'Current user',
            'data' => $user,
            'errors' => null
        ]);
    }

    public function logout(Request $request)
    {
        return $request->user()->tokens()->delete();
    }
}
