<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\LoginRequest;
use App\Http\Requests\Api\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    
    public function login ( LoginRequest $request )
    {
        $credentials = $request->validated();

        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $user = auth()->user(); $token = $user->createToken('Laravel Password Grant Client')->accessToken->token;


        return response()->json(['plain_text_token' => $token,]);
    }

    public function register ( RegisterRequest $request ) 
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
        
        event(new Registered($user));

        $token = $user->createToken('Automatic API login generated token')->accessToken->token;
        return response()->json(['plain_text_token' => $token]);
    }

    public function logout ( Request $request )
    {
        $request->user()->token()->revoke();
        return response()->json(['message' => 'Successfully logged out']);
    }

    public function user ( Request $request )
    {
        return response()->json($request->user());
    }
}
