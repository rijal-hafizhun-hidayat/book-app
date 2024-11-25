<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiAuthController extends Controller
{
    public function login(Request $request)
    {
        $creds = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        $isAuthAttemp = Auth::attempt($creds);

        if ($isAuthAttemp) {
            $token = $request->user()->createToken($creds['email'])->plainTextToken;
            return response()->json([
                'statusCode' => 200,
                'message' => 'success login',
                'token' => $token
            ], 200);
        } else {
            return response()->json([
                'statusCode' => 401,
                'message' => 'email or password not found',
            ], 401);
        }
    }
}
