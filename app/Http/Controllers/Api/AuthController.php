<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function me()
    {
        return response()->json([
            'message' => 'Success',
            'data' => [
                'user' => auth()->user(),
            ],
        ], 200);
    }

    public function login(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);

        if ($validate->fails()) {
            $respon = [
                'message' => 'Validator error',
                'errors' => $validate->errors(),
            ];
            return response()->json($respon, 200);
        } else {
            $credentials = [
                'email' => $request->input('email'),
                'password' => $request->input('password'),
                'status' => true,
            ];

            if (!auth()->attempt($credentials)) {
                $respon = [
                    'message' => 'Login gagal',
                    'errors' => null,
                ];
                return response()->json($respon, 401);
            }

            $user = User::where('email', $request->input('email'))->first();

            $respon = [
                'message' => 'Login berhasil',
                'access_token' => $user->createToken('authToken')->plainTextToken,
                'token_type' => 'Bearer',
                'data' => [
                    'user' => $user,
                ],
            ];
            return response()->json($respon, 200);
        }
    }

    public function register(Request $request)
    {
        //
    }
}
