<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Token;
use Illuminate\Support\Str;

class ApiController extends Controller
{
    //
    public function login(Request $request)
    {
        if (Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
            $user = Auth::user();
            $token = explode('|', $user->createToken('AuthToken')->plainTextToken, 2);
            $user['token']= $token[1];
            return response()->json(['success'=>'true','data' => $user,'message'=>'Login Success'], 200);
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out successfully'], 200);
    }
}
